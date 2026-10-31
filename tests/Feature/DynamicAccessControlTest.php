<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class DynamicAccessControlTest extends TestCase
{
    protected User $admin;
    protected Level $adminLevel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminLevel = Level::firstOrCreate(['nama' => 'admin'], ['is_system' => true]);
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@tend.clinic'],
            [
                'name'     => 'Admin Test',
                'password' => bcrypt('Password123!'),
                'level_id' => $this->adminLevel->id,
            ]
        );
    }

    public function test_admin_can_view_menu_and_level_index(): void
    {
        $resMenu = $this->actingAs($this->admin)->get(route('setting.menu.index'));
        $resMenu->assertStatus(200);

        $resLevel = $this->actingAs($this->admin)->get(route('setting.level.index'));
        $resLevel->assertStatus(200);
    }

    public function test_admin_can_create_menu_and_submenu(): void
    {
        // 1. Tambah menu utama (parent)
        $resParent = $this->actingAs($this->admin)->post(route('setting.menu.store'), [
            'parent_id' => null,
            'nama'      => 'Apotek',
            'url'       => '#',
            'icon'      => 'home',
        ]);
        $resParent->assertSessionHas('success');

        $parent = Menu::where('nama', 'Apotek')->first();
        $this->assertNotNull($parent);
        $this->assertEquals('#', $parent->url);

        // 2. Tambah sub-menu di bawah Apotek
        $resChild = $this->actingAs($this->admin)->post(route('setting.menu.store'), [
            'parent_id' => $parent->id,
            'nama'      => 'Daftar Obat',
            'url'       => 'apotek/obat',
            'icon'      => 'list',
        ]);
        $resChild->assertSessionHas('success');

        $child = Menu::where('nama', 'Daftar Obat')->first();
        $this->assertNotNull($child);
        $this->assertEquals($parent->id, $child->parent_id);

        // 3. Update data menu
        $resUpdate = $this->actingAs($this->admin)->put(route('setting.menu.update', $child), [
            'nama' => 'Katalog Obat Farmasi',
            'url'  => 'apotek/katalog',
            'icon' => 'shield',
        ]);
        $resUpdate->assertSessionHas('success');
        $child->refresh();
        $this->assertEquals('Katalog Obat Farmasi', $child->nama);
        $this->assertEquals('apotek/katalog', $child->url);

        // 4. Proteksi hapus: Parent yang punya anak TIDAK BOLEH dihapus
        $resDeleteParent = $this->actingAs($this->admin)->delete(route('setting.menu.destroy', $parent));
        $resDeleteParent->assertSessionHasErrors('menu');
        $this->assertDatabaseHas('menus', ['id' => $parent->id]);

        // 5. Hapus child terlebih dahulu, lalu parent
        $resDeleteChild = $this->actingAs($this->admin)->delete(route('setting.menu.destroy', $child));
        $resDeleteChild->assertSessionHas('success');
        $this->assertDatabaseMissing('menus', ['id' => $child->id]);

        $resDeleteParent2 = $this->actingAs($this->admin)->delete(route('setting.menu.destroy', $parent));
        $resDeleteParent2->assertSessionHas('success');
        $this->assertDatabaseMissing('menus', ['id' => $parent->id]);
    }

    public function test_cannot_create_third_level_submenu(): void
    {
        // Tingkat 1 (Menu Utama G)
        $parent = Menu::create(['nama' => 'Test G Utama', 'kode_menu' => 'TG', 'url' => '#']);
        // Tingkat 2 (Sub-menu G1)
        $child = Menu::create(['parent_id' => $parent->id, 'nama' => 'Test G1 Sub', 'kode_menu' => 'TG1', 'url' => 'test/g1']);

        // Mencoba membuat Tingkat 3 (G11) harus gagal validasi
        $res = $this->actingAs($this->admin)->post(route('setting.menu.store'), [
            'parent_id' => $child->id,
            'nama'      => 'Test G11 Sub-Sub',
            'url'       => 'test/g11',
        ]);
        $res->assertSessionHasErrors('parent_id');

        $child->delete();
        $parent->delete();
    }

    public function test_level_crud_and_access_matrix(): void
    {
        // 1. Create custom level with access permissions
        $leafMenu = Menu::whereDoesntHave('children')->first();
        $this->assertNotNull($leafMenu);

        $resStore = $this->actingAs($this->admin)->post(route('setting.level.store'), [
            'nama'   => 'apoteker_' . uniqid(),
            'access' => [
                $leafMenu->id => [
                    'view' => '1',
                    'add'  => '1',
                ],
            ],
        ]);
        $resStore->assertRedirect(route('setting.level.index'));
        $resStore->assertSessionHas('success');

        $level = Level::where('nama', 'like', 'apoteker_%')->first();
        $this->assertNotNull($level);

        // Verify level access pivot
        $pivot = $level->menus()->where('menu_id', $leafMenu->id)->first()?->pivot;
        $this->assertNotNull($pivot);
        $this->assertTrue((bool) $pivot->can_view);
        $this->assertTrue((bool) $pivot->can_add);
        $this->assertFalse((bool) $pivot->can_del);

        // 2. Edit level page returns 200
        $resEdit = $this->actingAs($this->admin)->get(route('setting.level.edit', $level));
        $resEdit->assertStatus(200);

        // 3. Update level access: add del permission
        $resUpdate = $this->actingAs($this->admin)->put(route('setting.level.update', $level), [
            'nama'   => $level->nama,
            'access' => [
                $leafMenu->id => [
                    'view' => '1',
                    'add'  => '1',
                    'del'  => '1',
                ],
            ],
        ]);
        $resUpdate->assertRedirect(route('setting.level.index'));

        $pivotUpdated = $level->fresh()->menus()->where('menu_id', $leafMenu->id)->first()?->pivot;
        $this->assertTrue((bool) $pivotUpdated->can_del);

        // 4. Test delete protection for system level
        $resDelSystem = $this->actingAs($this->admin)->delete(route('setting.level.destroy', $this->adminLevel));
        $resDelSystem->assertSessionHasErrors('level');

        // 5. Delete custom level
        $resDel = $this->actingAs($this->admin)->delete(route('setting.level.destroy', $level));
        $resDel->assertSessionHas('success');
        $this->assertDatabaseMissing('levels', ['id' => $level->id]);
    }

    public function test_sidebar_view_composer_filters_menus_by_user_permissions(): void
    {
        $customLevel = Level::create(['nama' => 'nurse_' . uniqid()]);
        $nurse = User::factory()->create(['level_id' => $customLevel->id]);

        // In the beginning, nurse has no access to any menu
        $rendered = $this->actingAs($nurse)->get(route('dashboard.index'))->getContent();
        // Since nurse has no view access to Setting (G1, G2, etc), Setting should not be present for nurse
        $this->assertStringNotContainsString('setting/level', $rendered);

        $nurse->delete();
        $customLevel->delete();
    }
}
