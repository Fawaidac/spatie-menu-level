import {
    $ as e,
    A as t,
    An as n,
    Bn as r,
    Cn as i,
    Dn as a,
    En as o,
    Fn as s,
    Gt as c,
    H as l,
    Ht as u,
    In as d,
    J as f,
    K as p,
    L as m,
    Ln as h,
    Mn as g,
    Mt as _,
    Nn as v,
    On as y,
    Pn as ee,
    R as te,
    Sn as b,
    Tn as x,
    U as S,
    Un as C,
    V as w,
    Vn as ne,
    W as T,
    Y as E,
    Zt as re,
    _t as D,
    at as O,
    bt as k,
    cn as A,
    ct as j,
    dt as ie,
    fn as M,
    ft as ae,
    jt as N,
    kn as P,
    lt as oe,
    mn as F,
    mt as se,
    nt as I,
    ot as ce,
    pn as L,
    q as le,
    rn as ue,
    sn as de,
    tn as R,
    un as fe,
    wn as z,
    z as pe,
} from './index-DwjwKIcQ.js';
var B = { quiet: !1 };
function V(...e) {
    B.quiet = !0;
    try {
        c(...e);
    } finally {
        B.quiet = !1;
    }
}
function me(e) {
    return e === `all` ? `All patients` : e === `recall` ? `Recalls due` : _[e];
}
function he(e) {
    return e === `all` ? `users` : e === `recall` ? `calCheck` : `tag`;
}
function H(e) {
    let t = e === `all` ? L.patients : e === `recall` ? fe() : L.patients.filter((t) => t.tags.includes(e)),
        n = t.filter((e) => e.consent !== `opted-out` && u(e));
    return {
        list: t,
        eligible: n,
        excluded: t.length - n.length,
        optedOut: t.filter((e) => e.consent === `opted-out`).length,
        pending: t.filter((e) => e.consent === `pending` && !n.includes(e)).length,
    };
}
function ge(e) {
    return [e.optedOut ? `${e.optedOut} opted out` : ``, e.pending ? `${e.pending} consent pending` : ``]
        .filter(Boolean)
        .join(`, `);
}
var _e = { first: `First name`, clinician: `Usual clinician`, clinic: `Clinic name`, text: `Custom text` };
function ve(e, t) {
    return e.src === `first`
        ? (t?.first ?? `Amina`)
        : e.src === `clinician`
          ? ((t && M(t.doctorId)?.short) ?? `Dr. Rahman`)
          : e.src === `clinic`
            ? L.settings.clinic.name
            : e.text.trim();
}
function ye(e) {
    let t = U(e.body);
    return Array.from({ length: t }, (t, n) => {
        let r = e.sample[n] ?? ``;
        return n === 0
            ? { src: `first`, text: `` }
            : /^dr\.?\s/i.test(r)
              ? { src: `clinician`, text: `` }
              : /clinic/i.test(r)
                ? { src: `clinic`, text: `` }
                : { src: `text`, text: r };
    });
}
var U = (e) => Math.max(0, ...[...e.matchAll(/\{\{(\d+)\}\}/g)].map((e) => Number(e[1]))),
    be = (e) => [...new Set([...e.matchAll(/\{\{(\d+)\}\}/g)].map((e) => Number(e[1])))],
    xe = /^[a-z0-9_]+$/,
    Se = /\b(discounts?|offers?|sales?|free|deals?|coupons?)\b|\d+\s*%\s*off\b|%\s*off\b/gi;
function Ce(e) {
    let t = [e.header ?? ``, e.body, e.footer ?? ``, ...e.buttons].join(` 
 `);
    return [...new Set([...t.matchAll(Se)].map((e) => e[0].toLowerCase().replace(/\s+/g, ` `)))];
}
var W = /\bstop\b|unsubscribe|opt[ -]?out/i,
    G = (e) => W.test(e.footer ?? ``) || e.buttons.some((e) => W.test(e)) || W.test(e.body),
    we = {
        utility: `About care the patient already has: reminders, results, recalls. No promotions.`,
        marketing: `Offers, news and campaigns. Only to opted-in patients, with a way to opt out.`,
        authentication: `One-time login codes. The body is the code and a security line.`,
    },
    K = [
        [`en_US`, `English (US)`],
        [`en_GB`, `English (UK)`],
        [`es_MX`, `Spanish (MX)`],
        [`es_ES`, `Spanish (ES)`],
        [`bn`, `Bengali`],
        [`ar`, `Arabic`],
        [`zh_CN`, `Chinese (simplified)`],
    ],
    q = (e) => K.find(([t]) => t === e)?.[1] ?? e,
    Te = (e) => `<span class="cp-cat cp-cat--${e}">${P(k[e])}</span>`,
    Ee = { approved: [`Approved`, `check`], pending: [`In review`, `hourglass`], rejected: [`Rejected`, `alert`] },
    De = (e) => `<span class="cp-tstat cp-tstat--${e}">${f(Ee[e][1])}${Ee[e][0]}</span>`,
    Oe = (e) => `<span class="cp-var">{{${e}}}</span>`,
    ke = (e) => (t) => {
        let n = e[t - 1];
        return n ? `<mark class="cp-fill">${P(n)}</mark>` : `<span class="cp-var cp-var--empty">{{${t}}}</span>`;
    };
function Ae(e, t) {
    return P(e).replace(/\{\{(\d+)\}\}/g, (e, n) => t(Number(n)));
}
function je(e, t, { time: n = !0, cls: r = `` } = {}) {
    let i = e.header?.trim() ? `<b class="bubble__head">${Ae(e.header.trim(), t)}</b>` : ``,
        a = e.footer?.trim() ? `<span class="cp-bubble__foot">${P(e.footer.trim())}</span>` : ``,
        o = n ? `<span class="bubble__meta">${T(Date.now())}</span>` : ``,
        s = e.buttons.filter((e) => e.trim()).length
            ? `<span class="bubble__btns">${e.buttons
                  .filter((e) => e.trim())
                  .map((e) => `<span>${f(`reply`)}${P(e.trim())}</span>`)
                  .join(``)}</span>`
            : ``;
    return `<div class="bubble bubble--in cp-bubble ${r}">${i}<span class="cp-bubble__body">${e.body.trim() ? Ae(e.body.trim(), t) : `<span class="cp-ghost">Your message appears here.</span>`}</span>${a}${o}${s}</div>`;
}
function Me(e) {
    let t = L.settings.whatsapp;
    return `<figure class="cp-phone" aria-label="${P(e)}">
    <div class="cp-phone__frame">
      <div class="cp-phone__status" aria-hidden="true"><span>9:41</span><i class="cp-phone__island"></i><span class="cp-phone__sys"><i></i><i></i><i></i></span></div>
      <div class="cp-phone__bar">
        <span class="cp-phone__back" aria-hidden="true">${f(`chevL`)}</span>
        <span class="cp-phone__av" aria-hidden="true">${f(`logo`)}</span>
        <span class="cp-phone__who"><b>${P(t.displayName)}${t.verified ? `<span class="cp-verified" title="Verified business" aria-label="Verified business">${f(`check`)}</span>` : ``}</b><small>Business account</small></span>
        <span class="cp-phone__tools" aria-hidden="true">${f(`video`)}${f(`phone`)}</span>
      </div>
      <div class="cp-phone__wall wa-wall"><span class="wa-day">Today</span><div class="cp-phone__slot" data-slot aria-live="polite"></div></div>
      <div class="cp-phone__input" aria-hidden="true"><span>${f(`smile`)}Message</span><i>${f(`send`)}</i></div>
    </div>
    <figcaption class="cp-phone__cap" data-cap></figcaption>
  </figure>`;
}
function Ne(e, t, n = !1) {
    let r = e.querySelector(`[data-slot]`);
    if (!r) return;
    r.innerHTML = t;
    let i = r.firstElementChild;
    n &&
        i &&
        !h() &&
        C.fromTo(
            i,
            { opacity: 0, y: 14, scale: 0.92, transformOrigin: `0% 0%` },
            { opacity: 1, y: 0, scale: 1, duration: y(0.55), ease: `back.out(1.7)`, clearProps: `transform,opacity` },
        );
}
var Pe = (e, t, n = `${t}s`) => `${E(e)} ${e === 1 ? t : n}`,
    Fe = { draft: `Draft`, scheduled: `Scheduled`, sending: `Sending`, sent: `Sent` },
    Ie = { sending: 0, scheduled: 1, draft: 2, sent: 3 },
    Le = [
        [`sent`, `Sent`],
        [`delivered`, `Delivered`],
        [`read`, `Read`],
        [`replied`, `Replied`],
        [`booked`, `Booked`],
    ],
    Re = () =>
        [...L.campaigns].sort(
            (e, t) => Ie[e.status] - Ie[t.status] || (e.status === `sent` ? t.at - e.at : e.at - t.at),
        ),
    ze = (e) => `<span class="cp-st cp-st--${e}"><i></i>${Fe[e]}</span>`;
function Be(e) {
    return e.status === `sent`
        ? `<b>Sent ${ce(e.at)}</b><small>${S(e.at)}</small>`
        : e.status === `sending`
          ? `<b>Sending now</b><small>Started ${S(e.at)}</small>`
          : e.status === `scheduled`
            ? `<b>Sends ${ce(e.at)}</b><small>${S(e.at)}</small>`
            : `<b>Not scheduled</b><small>${e.at > Date.now() ? `Planned for ${l(e.at)}` : `Draft`}</small>`;
}
function Ve(e) {
    if (e.status !== `draft` && e.recipients) return { recipients: e.recipients, excluded: e.excluded, why: `` };
    let t = H(e.audience);
    return { recipients: t.eligible.length, excluded: t.excluded, why: ge(t) };
}
function He(e) {
    let t = e.status === `sending` ? Math.max(e.recipients, 1) : Math.max(e.stats.sent, 1);
    return `<ol class="cp-funnel" aria-label="Delivery funnel">${Le.map(([n, r]) => {
        let i = e.stats[n],
            a = Math.min(1, i / t);
        return `<li class="cp-funnel__row" data-stage="${n}"><span class="cp-funnel__lab">${r}</span><span class="meter cp-funnel__meter"><span class="meter__fill cp-fill--${n}" data-v="${a}"></span></span><b class="cp-funnel__n" data-n="${i}">${E(i)}</b><span class="cp-funnel__pct" data-p>${I(a)}</span></li>`;
    }).join(``)}</ol>`;
}
function Ue(e) {
    let t = F(e.templateId);
    return t
        ? `<div class="cp-cast__wall wa-wall">${je(t, ke((e.vars ?? ye(t)).map((e) => ve(e, void 0))), { time: !1, cls: `cp-bubble--mini` })}</div>`
        : `<p class="cp-cast__missing">${f(`alert`)}The template for this broadcast was deleted.</p>`;
}
function We(e) {
    return e.status === `draft`
        ? `<button type="button" class="btn btn--sm btn--wa" data-act="send">${f(`send`)}Send now</button><a class="btn btn--sm btn--ghost" href="#/campaigns/edit/${encodeURIComponent(e.id)}">${f(`edit`)}Edit</a><span class="cp-spacer"></span>${le(`more`, `More for ${e.name}`, `data-act="more" aria-haspopup="menu" aria-expanded="false"`, `ibtn--sm`)}`
        : e.status === `scheduled`
          ? `<button type="button" class="btn btn--sm btn--ghost" data-act="unschedule">${f(`close`)}Cancel schedule</button><span class="cp-spacer"></span>${le(`copy`, `Duplicate ${e.name}`, `data-act="dup"`, `ibtn--sm`)}`
          : e.status === `sending`
            ? `<span class="cp-sending" role="status" data-progress>${f(`send`)}Sending ${E(e.stats.sent)} of ${E(e.recipients)}</span>`
            : `<button type="button" class="btn btn--sm btn--ghost" data-act="dup">${f(`copy`)}Duplicate</button><span class="cp-spacer"></span><span class="cp-cast__rate">${e.stats.booked ? `${f(`calCheck`)}<b>${E(e.stats.booked)}</b> booked` : ``}</span>`;
}
function Ge(e) {
    let t = F(e.templateId),
        n = Ve(e),
        r = e.status === `sent` || e.status === `sending`;
    return `<article class="cp-cast cp-cast--${e.status}" data-key="${P(e.id)}" aria-labelledby="cp-c-${P(e.id)}">
    <header class="cp-cast__head">
      <span class="cp-cast__ico" aria-hidden="true">${f(`megaphone`)}</span>
      <div class="cp-cast__title"><h3 id="cp-c-${P(e.id)}">${P(e.name)}</h3><p><code class="cp-mono">${P(t?.name ?? `deleted_template`)}</code></p></div>
      <span data-pill>${ze(e.status)}</span>
    </header>
    <dl class="cp-cast__facts">
      <div><dt class="sr">Audience</dt><dd>${f(he(e.audience))}<b>${P(me(e.audience))}</b></dd></div>
      <div><dt class="sr">When</dt><dd>${f(e.status === `scheduled` ? `clock` : `calendar`)}<span class="cp-when">${Be(e)}</span></dd></div>
      <div><dt class="sr">Recipients</dt><dd>${f(`whatsapp`)}<span><b data-recip>${E(n.recipients)}</b> ${n.recipients === 1 ? `recipient` : `recipients`}${e.status === `draft` ? ` <small>if sent now</small>` : ``}</span></dd></div>
    </dl>
    ${n.excluded ? `<p class="cp-excl">${f(`lock`)}<span><b>${E(n.excluded)} excluded</b> — no WhatsApp consent${n.why ? ` <small>(${P(n.why)})</small>` : ``}</span></p>` : ``}
    ${r ? He(e) : Ue(e)}
    <footer class="cp-cast__foot">${We(e)}</footer>
  </article>`;
}
function J(e, t, n = 0) {
    let r = i(`.cp-funnel .meter__fill[data-v]`, e);
    if (!t || h()) {
        r.forEach((e) => C.set(e, { scaleX: Number(e.dataset.v) }));
        return;
    }
    let a = new Map();
    (r.forEach((e) => {
        let t = e.closest(`.cp-cast`);
        a.set(t, [...(a.get(t) ?? []), e]);
    }),
        [...a.values()].forEach((e, t) => {
            C.fromTo(
                e,
                { scaleX: 0 },
                {
                    scaleX: (t) => Number(e[t].dataset.v),
                    duration: y(1.1),
                    ease: `power3.out`,
                    stagger: y(0.09),
                    delay: y(n + t * 0.08),
                },
            );
        }));
}
function Ke(e, t = 0) {
    i(`.cp-funnel__n`, e).forEach((e, n) =>
        o(e, Number(e.dataset.n), E, { from: 0, duration: 1.3, delay: t + (n % 5) * 0.09 }),
    );
}
function qe() {
    let e = Re();
    return e.length
        ? `<div class="cp-casts" data-casts>${e.map(Ge).join(``)}</div>`
        : m(
              `No broadcasts yet`,
              `Send an approved template to a group of patients who opted in.`,
              `megaphone`,
              `<a class="btn btn--primary btn--sm" href="#/campaigns/new">${f(`plus`)}New broadcast</a>`,
          );
}
function Je(e) {
    let t = z(`[data-casts]`, e);
    if (!t || !L.campaigns.length) {
        ((e.innerHTML = qe()), J(e, !1));
        return;
    }
    w(t, () => {
        ((t.innerHTML = Re().map(Ge).join(``)), J(t, !1));
    });
}
function Ye(t, n) {
    t.addEventListener(`click`, async (r) => {
        let i = r.target.closest(`[data-act]`),
            a = i?.closest(`.cp-cast`);
        if (!i || !a) return;
        let o = L.campaigns.find((e) => e.id === a.dataset.key);
        if (!o) return;
        let s = i.dataset.act;
        s === `send`
            ? Xe(o, t, n)
            : s === `unschedule`
              ? Qe(o, t)
              : s === `dup`
                ? $e(o, t)
                : s === `more` &&
                  e(i, [
                      { label: `Duplicate`, icon: `copy`, onSelect: () => $e(o, t) },
                      `-`,
                      { label: `Delete draft`, icon: `trash`, danger: !0, onSelect: () => et(o, t) },
                  ]);
    });
}
async function Xe(e, n, r) {
    let i = F(e.templateId);
    if (!L.settings.whatsapp.connected) {
        D(`WhatsApp is disconnected. Reconnect it in Settings.`, { ico: `alert` });
        return;
    }
    if (!i) {
        D(`This broadcast’s template was deleted. Edit it and pick another.`, { ico: `alert` });
        return;
    }
    if (i.status !== `approved`) {
        D(
            `${i.name} is ${i.status === `pending` ? `still in review` : `rejected`}. Only approved templates can be sent.`,
            { ico: `hourglass` },
        );
        return;
    }
    let a = H(e.audience);
    if (!a.eligible.length) {
        D(`Nobody in this audience has WhatsApp consent.`, { ico: `lock` });
        return;
    }
    (await t(
        `Send “${e.name}” now?`,
        `${Pe(a.eligible.length, `patient`)} will get ${i.name} on WhatsApp.${a.excluded ? ` ${E(a.excluded)} without consent are skipped.` : ``}`,
        `Send to ${E(a.eligible.length)}`,
        !1,
    )) && ((e.recipients = a.eligible.length), (e.excluded = a.excluded), Ze(e, n), r());
}
function Ze(e, t) {
    if (
        ((e.status = `sending`),
        (e.at = Date.now()),
        (e.stats = { sent: 0, delivered: 0, read: 0, replied: 0, failed: 0, booked: 0 }),
        R(`campaign`, `started sending ${e.name}`),
        V(`campaigns`, `activity`),
        t)
    ) {
        let e = z(`[data-casts]`, t);
        e &&
            w(e, () => {
                ((e.innerHTML = Re().map(Ge).join(``)), J(e, !1));
            });
    }
    nt(e);
}
function Qe(e, t) {
    let n = e.at;
    ((e.status = `draft`),
        R(`campaign`, `cancelled the schedule for ${e.name}`),
        V(`campaigns`, `activity`),
        Je(t),
        D(`“${e.name}” is a draft again`, {
            ico: `clock`,
            undo: () => {
                ((e.status = `scheduled`), (e.at = n), V(`campaigns`), Je(t));
            },
        }));
}
function $e(e, t) {
    let n = {
        ...e,
        id: ue(`b`),
        name: `${e.name} (copy)`,
        status: `draft`,
        at: Date.now(),
        recipients: 0,
        excluded: 0,
        stats: { sent: 0, delivered: 0, read: 0, replied: 0, failed: 0, booked: 0 },
    };
    (L.campaigns.unshift(n),
        R(`campaign`, `duplicated ${e.name}`),
        V(`campaigns`, `activity`),
        Je(t),
        D(`Draft “${n.name}” created`, { ico: `copy` }));
}
async function et(e, n) {
    if (!(await t(`Delete “${e.name}”?`, `This draft is removed for everyone at the clinic.`, `Delete draft`))) return;
    let r = z(`.cp-cast[data-key="${CSS.escape(e.id)}"]`, n),
        i = () => {
            ((L.campaigns = L.campaigns.filter((t) => t !== e)),
                R(`campaign`, `deleted the draft ${e.name}`),
                V(`campaigns`, `activity`),
                Je(n),
                D(`Draft deleted`, { ico: `trash` }));
        };
    r ? pe(r, i) : i();
}
var tt = new Set();
function nt(e) {
    if (tt.has(e.id)) return;
    tt.add(e.id);
    let t = F(e.templateId),
        n = Math.max(1, e.recipients),
        r = [...e.id].reduce((e, t) => e + t.charCodeAt(0), 0),
        i = (e) => ((r * (e + 3)) % 17) / 100,
        a = Math.max(0, n - Math.max(+(n > 20), Math.round(n * 0.012))),
        s = { sent: n, delivered: a, read: Math.round(a * (0.8 + i(1) / 2)), replied: 0, booked: 0, failed: n - a };
    ((s.replied = Math.round(s.read * (t?.category === `marketing` ? 0.2 + i(2) / 2 : 0.36 + i(2)))),
        (s.booked = Math.round(s.replied * (0.55 + i(3)))));
    let c = { ...e.stats },
        l = +!h(),
        u = C.timeline({ onUpdate: _, onComplete: v }),
        p = `power2.out`;
    u.to(c, { sent: s.sent, duration: 1.8 * l, ease: `power1.inOut` }, 0)
        .to(c, { delivered: s.delivered, duration: 2 * l, ease: p }, 0.45 * l)
        .to(c, { read: s.read, duration: 2.6 * l, ease: p }, 1.3 * l)
        .to(c, { replied: s.replied, duration: 2.4 * l, ease: p }, 2.4 * l)
        .to(c, { booked: s.booked, duration: 2 * l, ease: p }, 3.3 * l);
    let m = e.stats.replied;
    function _() {
        ([`sent`, `delivered`, `read`, `replied`, `booked`].forEach((t) => {
            e.stats[t] = Math.round(c[t]);
        }),
            (e.stats.failed = Math.round((c.sent / n) * s.failed)));
        let t = document.querySelector(`[data-view="campaigns"] .cp-cast[data-key="${CSS.escape(e.id)}"]`);
        if (!t) return;
        Le.forEach(([r]) => {
            let i = t.querySelector(`.cp-funnel__row[data-stage="${r}"]`);
            if (!i) return;
            let a = Math.min(1, e.stats[r] / n),
                s = i.querySelector(`.meter__fill`);
            ((s.dataset.v = String(a)), C.set(s, { scaleX: a }));
            let c = i.querySelector(`.cp-funnel__n`);
            ((c.dataset.n = String(e.stats[r])),
                o(c, e.stats[r], E, { duration: 0 }),
                (i.querySelector(`[data-p]`).textContent = I(a)));
        });
        let r = t.querySelector(`[data-progress]`);
        (r && (r.innerHTML = `${f(`send`)}Sending ${E(e.stats.sent)} of ${E(n)}`),
            e.stats.replied - m >= Math.max(1, Math.round(n / 40)) &&
                ((m = e.stats.replied), x(t.querySelector(`[data-stage="replied"] .cp-funnel__n`))));
    }
    function v() {
        (_(),
            tt.delete(e.id),
            (e.stats = { ...s }),
            (e.status = `sent`),
            t && ((t.sent += s.sent), (t.read += s.read), (t.replied += s.replied)),
            R(`campaign`, `sent ${e.name} to ${E(n)} patients`),
            de(`Broadcast “${e.name}” sent: ${E(s.read)} read, ${E(s.booked)} booked`, `#/campaigns`),
            V(`campaigns`, `templates`, `activity`, `notices`));
        let r = document
            .querySelector(`[data-view="campaigns"] .cp-cast[data-key="${CSS.escape(e.id)}"]`)
            ?.parentElement?.closest(`[data-body]`);
        if (r) {
            let t = z(`[data-casts]`, r);
            w(t, () => {
                ((t.innerHTML = Re().map(Ge).join(``)), J(t, !1));
            });
            let n = z(`.cp-cast[data-key="${CSS.escape(e.id)}"]`, t);
            (d(z(`[data-pill] .cp-st`, n ?? t), { from: 0.7 }),
                g(z(`.cp-cast__rate`, n ?? t), `+${E(s.booked)} booked`));
        }
        D(`“${e.name}” sent to ${Pe(n, `patient`)}`, { ico: `send` });
    }
}
function rt() {
    L.campaigns.filter((e) => e.status === `sending`).forEach((e) => nt(e));
}
var Y = { cat: `all`, stat: `all` },
    it = () =>
        L.templates.filter(
            (e) => (Y.cat === `all` || e.category === Y.cat) && (Y.stat === `all` || e.status === Y.stat),
        );
function at(e) {
    let t = e.sent,
        n = t ? e.read / t : 0,
        r = t ? e.replied / t : 0,
        i =
            e.status === `approved` && e.category !== `authentication`
                ? `<a class="btn btn--sm btn--soft" href="#/campaigns/new/${encodeURIComponent(e.id)}">${f(`megaphone`)}Use in broadcast</a>`
                : e.status === `rejected`
                  ? `<a class="btn btn--sm btn--ghost" href="#/campaigns/templates/edit/${encodeURIComponent(e.id)}">${f(`edit`)}Edit &amp; resubmit</a>`
                  : e.status === `pending`
                    ? `<span class="cp-review" role="status"><i aria-hidden="true"></i>Waiting for Meta</span>`
                    : `<span class="cp-review cp-review--auth">${f(`lock`)}Sent by the patient portal</span>`;
    return `<article class="cp-tpl cp-tpl--${e.status}" data-key="${P(e.id)}" aria-labelledby="cp-t-${P(e.id)}">
    <header class="cp-tpl__head">
      <h3 class="cp-tpl__name" id="cp-t-${P(e.id)}"><code class="cp-mono">${P(e.name)}</code></h3>
      <span data-tstat>${De(e.status)}</span>
    </header>
    <p class="cp-tpl__meta">${Te(e.category)}<span>${f(`globe`)}${P(q(e.lang))}</span><span>${f(`clock`)}${ce(e.updated)}</span></p>
    <div class="cp-tpl__wall wa-wall">${je(e, Oe, { time: !1 })}</div>
    ${e.status === `rejected` && e.reason ? `<p class="note cp-note--bad">${f(`alert`)}<span><b>Rejected by Meta.</b> ${P(e.reason)}</span></p>` : ``}
    ${e.status === `pending` ? `<p class="note">${f(`hourglass`)}<span><b>In review.</b> Meta usually decides within minutes, at most 24 hours.</span></p>` : ``}
    <dl class="cp-tpl__stats">
      <div><dt>Sent</dt><dd data-s="sent">${E(t)}</dd></div>
      <div><dt>Read</dt><dd data-s="read">${t ? I(n) : `—`}</dd></div>
      <div><dt>Replied</dt><dd data-s="replied">${t ? I(r) : `—`}</dd></div>
    </dl>
    <footer class="cp-tpl__foot">${i}<span class="cp-spacer"></span>${le(`more`, `More for ${e.name}`, `data-tact="more" aria-haspopup="menu" aria-expanded="false"`, `ibtn--sm`)}</footer>
  </article>`;
}
function ot() {
    let e = it();
    return L.templates.length
        ? e.length
            ? `<div class="cp-tpls" data-tpls>${e.map(at).join(``)}</div>`
            : `<div data-tpls>${m(`No templates match`, `Try another category or status.`, `filter`, `<button type="button" class="btn btn--ghost btn--sm" data-clear>Clear filters</button>`)}</div>`
        : m(
              `No templates yet`,
              `Create one and submit it to Meta. Approved templates can be sent at any time.`,
              `template`,
              `<a class="btn btn--primary btn--sm" href="#/campaigns/templates/new">${f(`plus`)}New template</a>`,
          );
}
function st(e) {
    let t = z(`.cp-tpls`, e);
    if (!t || !it().length) {
        e.innerHTML = ot();
        return;
    }
    w(t, () => {
        t.innerHTML = it().map(at).join(``);
    });
}
function ct(e) {
    L.templates.forEach((t) => {
        let n = z(`.cp-tpl[data-key="${CSS.escape(t.id)}"]`, e);
        if (!n) return;
        let r = z(`[data-s="sent"]`, n);
        r &&
            r.textContent !== E(t.sent) &&
            ((r.textContent = E(t.sent)),
            x(r),
            (z(`[data-s="read"]`, n).textContent = t.sent ? I(t.read / t.sent) : `—`),
            (z(`[data-s="replied"]`, n).textContent = t.sent ? I(t.replied / t.sent) : `—`));
    });
}
function lt(t, n) {
    t.addEventListener(`click`, (r) => {
        let i = r.target;
        if (i.closest(`[data-clear]`)) {
            n();
            return;
        }
        let a = i.closest(`[data-tact]`),
            o = a?.closest(`.cp-tpl`);
        if (!a || !o) return;
        let s = L.templates.find((e) => e.id === o.dataset.key);
        s &&
            e(a, [
                ...(s.status === `approved` && s.category !== `authentication`
                    ? [
                          {
                              label: `Use in broadcast`,
                              icon: `megaphone`,
                              onSelect: () => {
                                  location.hash = `#/campaigns/new/${s.id}`;
                              },
                          },
                      ]
                    : []),
                {
                    label: `Duplicate`,
                    icon: `copy`,
                    onSelect: () => {
                        location.hash = `#/campaigns/templates/copy/${s.id}`;
                    },
                },
                ...(s.status === `rejected`
                    ? [
                          {
                              label: `Edit & resubmit`,
                              icon: `edit`,
                              onSelect: () => {
                                  location.hash = `#/campaigns/templates/edit/${s.id}`;
                              },
                          },
                      ]
                    : []),
                `-`,
                { label: `Delete template`, icon: `trash`, danger: !0, onSelect: () => ut(s, t) },
            ]);
    });
}
async function ut(e, n) {
    let r = L.campaigns.filter(
        (t) => t.templateId === e.id && (t.status === `draft` || t.status === `scheduled` || t.status === `sending`),
    );
    if (r.length) {
        D(`“${r[0].name}” still uses ${e.name}. Change or delete that broadcast first.`, { ico: `alert` });
        return;
    }
    if (
        !(await t(
            `Delete ${e.name}?`,
            `It is removed from Meta too. Sent messages stay in each conversation.`,
            `Delete template`,
        ))
    )
        return;
    let i = z(`.cp-tpl[data-key="${CSS.escape(e.id)}"]`, n),
        a = () => {
            ((L.templates = L.templates.filter((t) => t !== e)),
                R(`template`, `deleted the template ${e.name}`),
                V(`templates`, `activity`),
                st(n),
                D(`${e.name} deleted`, { ico: `trash` }));
        };
    i ? pe(i, a) : a();
}
function dt(e) {
    ((e.status = `pending`),
        (e.updated = Date.now()),
        delete e.reason,
        R(`template`, `submitted ${e.name} for approval`),
        de(`Template ${e.name} is waiting for Meta’s review`, `#/campaigns/templates`),
        V(`templates`, `activity`, `notices`),
        setTimeout(() => ft(e), 3600 + Math.random() * 1400));
}
function ft(e) {
    if (!L.templates.includes(e) || e.status !== `pending`) return;
    let t = e.category === `utility` ? Ce(e) : [];
    (t.length
        ? ((e.status = `rejected`),
          (e.reason = `Promotional content (“${t.slice(0, 2).join(`”, “`)}”) in a Utility template. Resubmit as Marketing, or remove the offer.`))
        : (e.status = `approved`),
        (e.updated = Date.now()));
    let n = e.status === `approved`;
    (R(`template`, `${e.name} was ${n ? `approved` : `rejected`} by Meta`),
        de(
            n ? `Template ${e.name} was approved` : `Template ${e.name} was rejected: promotional content`,
            `#/campaigns/templates`,
        ),
        V(`templates`, `activity`, `notices`));
    let r = document.querySelector(`[data-view="campaigns"]:not([hidden]) .cp-tpl[data-key="${CSS.escape(e.id)}"]`);
    if (r) {
        let t = document.createElement(`div`);
        t.innerHTML = at(e);
        let n = t.firstElementChild;
        h()
            ? r.replaceWith(n)
            : C.to(r, {
                  rotationY: 90,
                  opacity: 0.4,
                  duration: y(0.22),
                  ease: `power2.in`,
                  transformPerspective: 900,
                  onComplete: () => {
                      (r.replaceWith(n),
                          C.fromTo(
                              n,
                              { rotationY: -90, opacity: 0.4, transformPerspective: 900 },
                              {
                                  rotationY: 0,
                                  opacity: 1,
                                  duration: y(0.5),
                                  ease: `back.out(1.6)`,
                                  clearProps: `transform,opacity`,
                              },
                          ),
                          d(z(`[data-tstat] .cp-tstat`, n), { from: 0.5, delay: 0.25 }),
                          z(`[data-tstat]`, n)?.classList.add(`is-flash`));
                  },
              });
    }
    D(n ? `${e.name} approved — ready to send` : `${e.name} rejected: promotional content in a Utility template`, {
        ico: n ? `check` : `alert`,
    });
}
var pt = () => {
        let e = (e) => L.templates.filter((t) => t.status === e).length;
        return `${E(e(`approved`))} approved · ${E(e(`pending`))} in review · ${E(e(`rejected`))} rejected`;
    },
    mt = [
        { title: `Choose a template`, label: `Template`, sub: `Only templates Meta approved can be broadcast.` },
        { title: `Choose the audience`, label: `Audience`, sub: `Only patients who opted in to WhatsApp receive it.` },
        {
            title: `Fill the variables`,
            label: `Variables`,
            sub: `Each {{n}} is filled per patient as the message goes out.`,
        },
        { title: `Name and send`, label: `Schedule`, sub: `Send it now, or pick a time patients are awake.` },
    ],
    ht = (e) => String(e).padStart(2, `0`),
    gt = (e) => `${e.getFullYear()}-${ht(e.getMonth() + 1)}-${ht(e.getDate())}`,
    _t = (e) => {
        let t = e.replace(/_/g, ` `);
        return t.charAt(0).toUpperCase() + t.slice(1);
    },
    vt = (e) => e.status === `approved` && e.category !== `authentication`;
function yt(e, r) {
    let a = r[0] === `edit` ? (L.campaigns.find((e) => e.id === r[1] && e.status === `draft`) ?? null) : null,
        c = r[0] === `new` && r[1] ? F(r[1]) : void 0,
        l = new Date(Date.now() + 864e5),
        u = a ? F(a.templateId) : c && vt(c) ? c : void 0,
        d = {
            step: c && vt(c) ? 2 : 1,
            templateId: u?.id ?? null,
            kind: a ? (a.audience === `all` ? `all` : a.audience === `recall` ? `recall` : `tag`) : `all`,
            tag: a && a.audience !== `all` && a.audience !== `recall` ? a.audience : `chronic`,
            maps: a ? (a.vars ?? (u ? ye(u) : [])) : u ? ye(u) : [],
            when: a && a.at > Date.now() ? `later` : `now`,
            date: gt(a && a.at > Date.now() ? new Date(a.at) : l),
            time:
                a && a.at > Date.now()
                    ? `${ht(new Date(a.at).getHours())}:${ht(new Date(a.at).getMinutes())}`
                    : `09:30`,
            name: a?.name ?? (u ? _t(u.name) : ``),
            nameEdited: !!a,
            asIdx: 0,
        };
    r[0] === `edit` && !a && D(`That broadcast can’t be edited any more — starting a new one`, { ico: `info` });
    let m = !1,
        g = document.createElement(`div`);
    ((g.className = `cp-focus cp-compose`),
        (g.innerHTML = `${p({ title: a ? `Edit broadcast` : `New broadcast`, eyebrow: `Campaigns · WhatsApp broadcast`, back: `#/campaigns` })}
    <div class="cp-cmp">
      <nav class="cp-steps" aria-label="Broadcast steps"><span class="cp-steps__pill" aria-hidden="true"></span><ol>${mt.map((e, t) => `<li><button type="button" class="cp-steps__btn" data-step="${t + 1}"><span class="cp-steps__n" aria-hidden="true"><span>${t + 1}</span>${f(`check`)}</span><span class="cp-steps__txt"><b>${e.label}</b><small data-sum="${t + 1}"></small></span></button></li>`).join(``)}</ol></nav>
      <section class="card cp-panel" aria-labelledby="cp-step-title">
        <header class="cp-panel__head"><p class="cp-panel__n" data-stepn></p><h2 class="cp-panel__title" id="cp-step-title" tabindex="-1" data-steptitle></h2><p class="cp-panel__sub" data-stepsub></p></header>
        <div class="cp-panel__body" data-pbody></div>
        <p class="cp-err" role="alert" data-err></p>
        <footer class="cp-panel__foot">
          <button type="button" class="btn btn--ghost cp-cancel" data-cancel>Cancel</button>
          <span class="cp-spacer"></span>
          <button type="button" class="btn btn--ghost" data-draft>${f(`note`)}<span>Save draft</span></button>
          <button type="button" class="btn btn--ghost" data-back>${f(`chevL`)}<span>Back</span></button>
          <button type="button" class="btn btn--primary magnetic" data-next></button>
        </footer>
      </section>
      <aside class="cp-preview" aria-label="Preview">${Me(`What patients will see`)}</aside>
    </div>`),
        e.replaceChildren(g));
    let _ = b(`[data-pbody]`, g),
        v = b(`[data-err]`, g),
        x = b(`.cp-phone`, g),
        w = b(`.cp-steps`, g),
        T = b(`.cp-steps__pill`, g),
        O = () => (d.templateId ? F(d.templateId) : void 0),
        k = () => (d.kind === `tag` ? d.tag : d.kind),
        A = () => H(k()),
        j = () => {
            let e = A().eligible;
            return e.length ? e[d.asIdx % e.length] : L.patients[0];
        };
    function M(e) {
        let t = O();
        if (e === 1) {
            if (!t) return `Choose a template to continue.`;
            if (!vt(t))
                return `${t.name} is ${t.status === `pending` ? `still in review` : t.status === `rejected` ? `rejected` : `for login codes only`}. Choose an approved template.`;
        }
        if (e === 2 && !A().eligible.length)
            return `Nobody in this audience opted in to WhatsApp. Choose another audience.`;
        if (e === 3) {
            let e = d.maps.findIndex((e) => e.src === `text` && !e.text.trim());
            if (e >= 0) return `Add the text for {{${e + 1}}}, or fill it from the patient record.`;
        }
        if (e === 4) {
            if (!d.name.trim()) return `Give the broadcast a name your team will recognise.`;
            if (d.when === `later`) {
                let e = new Date(`${d.date}T${d.time}`).getTime();
                if (!d.date || !d.time || Number.isNaN(e)) return `Pick a date and a time.`;
                if (e < Date.now() + 5 * 6e4) return `Pick a time at least five minutes from now.`;
            } else if (!L.settings.whatsapp.connected)
                return `WhatsApp is disconnected. Reconnect it in Settings, or schedule for later.`;
        }
        return null;
    }
    let oe = (e) => {
        for (let t = 1; t < e; t++) if (M(t)) return t;
        return 0;
    };
    function ce() {
        let e = L.templates
                .filter((e) => vt(e) || e.id === d.templateId)
                .sort((e, t) => Number(t.id === d.templateId) - Number(e.id === d.templateId)),
            t = L.templates.filter((e) => e.status !== `approved`).length;
        return `<ul class="cp-why"><li>${Te(`utility`)}<span>${P(we.utility)}</span></li><li>${Te(`marketing`)}<span>${P(we.marketing)}</span></li></ul>
      <fieldset class="cp-opts cp-opts--tpl"><legend class="sr">Template</legend>${e
          .map((e) => {
              let t = !vt(e);
              return `<label class="cp-opt cp-topt${t ? ` is-off` : ``}"><input class="sr" type="radio" name="cp-tpl" value="${P(e.id)}" ${e.id === d.templateId ? `checked` : ``} />
          <span class="cp-topt__head"><code class="cp-mono">${P(e.name)}</code>${Te(e.category)}</span>
          <span class="cp-topt__body">${e.header ? `<b>${P(e.header)}</b> ` : ``}${le(e)}</span>
          <span class="cp-topt__meta">${t ? `${f(`hourglass`)}${e.status === `pending` ? `In review — can be saved as a draft only` : `Not approved`}` : `${f(`send`)}${E(e.sent)} sent · ${e.sent ? I(e.read / e.sent) : `—`} read`}</span>
          <span class="cp-opt__tick" aria-hidden="true">${f(`check`)}</span></label>`;
          })
          .join(``)}</fieldset>
      ${t ? `<p class="cp-more">${f(`info`)}<span>${Pe(t, `template`)} ${t === 1 ? `is` : `are`} in review or rejected. <a href="#/campaigns/templates">Manage templates</a></span></p>` : ``}`;
    }
    let le = (e) => P(e.body).replace(/\{\{(\d+)\}\}/g, (e, t) => Oe(Number(t)));
    function de() {
        let e = (
            e,
            t,
            n,
            r,
            i,
        ) => `<label class="cp-opt cp-aopt"><input class="sr" type="radio" name="cp-aud" value="${e}" ${d.kind === e ? `checked` : ``} />
      <span class="cp-aopt__ico" aria-hidden="true">${f(t)}</span><span class="cp-aopt__txt"><b>${n}</b><small>${r}</small></span><span class="cp-aopt__n" data-kn="${e}">${E(i)}</span><span class="cp-opt__tick" aria-hidden="true">${f(`check`)}</span></label>`;
        return `<fieldset class="cp-opts cp-opts--aud"><legend class="sr">Audience</legend>
        ${e(`all`, `users`, `All patients`, `Everyone who opted in`, H(`all`).eligible.length)}
        ${e(`tag`, `tag`, `Patients with a tag`, `Pick the tag below`, H(d.tag).eligible.length)}
        ${e(`recall`, `calCheck`, `Recalls due`, `Check-up due in 14 days, nothing booked`, H(`recall`).eligible.length)}
      </fieldset>
      <fieldset class="cp-tags" data-tags ${d.kind === `tag` ? `` : `hidden`}><legend class="sr">Tag</legend>${N.map((e) => `<label class="cp-tagopt"><input class="sr" type="radio" name="cp-tag" value="${e}" ${d.tag === e ? `checked` : ``} />${se(e)}<small>${E(H(e).eligible.length)}</small></label>`).join(``)}</fieldset>
      <div class="cp-reach" data-reach></div>
      <div data-policy></div>`;
    }
    let fe = 0;
    function pe(e) {
        let t = z(`[data-reach]`, _);
        if (!t) return;
        let n = A(),
            r = Math.max(1, n.list.length),
            i = n.eligible.length / r,
            a = n.eligible.slice(0, 6).map((e) => e.id),
            s = z(`[data-elig]`, t),
            c = s ? Number(s.dataset.v) : 0;
        t.innerHTML = `<div class="cp-reach__top"><p class="cp-reach__num"><b data-elig data-v="${n.eligible.length}">${E(n.eligible.length)}</b><span>${n.eligible.length === 1 ? `patient gets` : `patients get`} this</span></p>${a.length ? `<span class="cp-reach__who">${ae(a, `sm`)}${n.eligible.length > a.length ? `<small>+${E(n.eligible.length - a.length)}</small>` : ``}</span>` : ``}</div>
      <span class="meter cp-reach__meter" role="img" aria-label="${E(n.eligible.length)} of ${E(n.list.length)} in this audience can be messaged"><span class="meter__fill meter__fill--wa"></span></span>
      <p class="cp-reach__ex">${n.excluded ? `${f(`lock`)}<span><b>${E(n.excluded)} excluded</b> — no WhatsApp consent${ge(n) ? ` (${P(ge(n))})` : ``}</span>` : `${f(`check`)}<span>Everyone in this audience opted in.</span>`}</p>`;
        let l = b(`.meter__fill`, t);
        (e && !h()
            ? C.fromTo(l, { scaleX: fe }, { scaleX: i, duration: y(0.7), ease: `power3.out` })
            : C.set(l, { scaleX: i }),
            (fe = i),
            o(z(`[data-elig]`, t), n.eligible.length, E, { from: e ? c : n.eligible.length, duration: 0.6 }));
        let u = O();
        b(`[data-policy]`, _).innerHTML =
            u?.category === `marketing`
                ? `<p class="note">${f(`shield`)}<span><b>Marketing template.</b> Patients can reply STOP to opt out, and Tend stops messaging them at once.</span></p>`
                : `<p class="note">${f(`shield`)}<span><b>Utility template.</b> It must be about care the patient already has. Anything promotional needs a Marketing template.</span></p>`;
    }
    function B() {
        let e = O();
        if (!U(e.body))
            return `<div class="cp-novars">${f(`check`)}<p><b>Nothing to fill.</b> ${P(e.name)} has no variables — every patient gets the same text.</p></div>`;
        let t = j();
        return `<div class="cp-maps">${d.maps
            .map(
                (e, n) => `<div class="cp-map">
        <span class="cp-var cp-var--lg" aria-hidden="true">{{${n + 1}}}</span>
        <label class="field cp-map__src"><span class="field__label">Fill {{${n + 1}}} with</span><select data-map="${n}">${Object.keys(
            _e,
        )
            .map((t) => `<option value="${t}" ${e.src === t ? `selected` : ``}>${_e[t]}</option>`)
            .join(``)}</select></label>
        <label class="field cp-map__text" ${e.src === `text` ? `` : `hidden`}><span class="field__label">Text for everyone</span><input data-mtext="${n}" value="${P(e.text)}" maxlength="60" placeholder="e.g. Saturday" autocomplete="off" /></label>
        <p class="cp-map__eg" ${e.src === `text` ? `hidden` : ``}>${P(t ? re(t) : `Patient`)} gets <mark class="cp-fill" data-eg="${n}">${P(ve(e, t) || `…`)}</mark></p>
      </div>`,
            )
            .join(``)}</div>`;
    }
    function he() {
        let e = be();
        return `<label class="field cp-name"><span class="field__label">Broadcast name</span><input data-name value="${P(d.name)}" maxlength="60" autocomplete="off" placeholder="e.g. Flu shot season" /><span class="field__hint">Only your team sees this.</span></label>
      <fieldset class="cp-opts cp-opts--when"><legend class="sr">When</legend>
        <label class="cp-opt cp-aopt"><input class="sr" type="radio" name="cp-when" value="now" ${d.when === `now` ? `checked` : ``} /><span class="cp-aopt__ico" aria-hidden="true">${f(`send`)}</span><span class="cp-aopt__txt"><b>Send now</b><small>Starts right away, at WhatsApp’s pace</small></span><span class="cp-opt__tick" aria-hidden="true">${f(`check`)}</span></label>
        <label class="cp-opt cp-aopt"><input class="sr" type="radio" name="cp-when" value="later" ${d.when === `later` ? `checked` : ``} /><span class="cp-aopt__ico" aria-hidden="true">${f(`clock`)}</span><span class="cp-aopt__txt"><b>Schedule</b><small>Pick a date and time</small></span><span class="cp-opt__tick" aria-hidden="true">${f(`check`)}</span></label>
      </fieldset>
      <div class="cp-sched" data-sched ${d.when === `later` ? `` : `hidden`}>
        <label class="field"><span class="field__label">Date</span><input type="date" data-date value="${d.date}" min="${gt(new Date())}" /></label>
        <label class="field"><span class="field__label">Time</span><input type="time" data-time value="${d.time}" step="300" /></label>
      </div>
      <p class="note note--warn" data-quiet ${e ? `` : `hidden`}>${f(`moon`)}<span><b>Outside 8 AM–8 PM.</b> Patients are more likely to mute or block a clinic that writes late.</span></p>
      <dl class="cp-sum" data-sumlist>${xe()}</dl>`;
    }
    function be() {
        if (d.when !== `later` || !d.time) return !1;
        let e = Number(d.time.slice(0, 2));
        return e < 8 || e >= 20;
    }
    function xe() {
        let e = O(),
            t = A(),
            n = new Date(`${d.date}T${d.time}`).getTime();
        return [
            [`Template`, e ? `<code class="cp-mono">${P(e.name)}</code>` : `—`],
            [`Audience`, P(me(k()))],
            [
                `Recipients`,
                `<b>${E(t.eligible.length)}</b>${t.excluded ? ` <small>· ${E(t.excluded)} excluded</small>` : ``}`,
            ],
            [`When`, d.when === `now` ? `Right away` : Number.isNaN(n) ? `—` : P(S(n))],
        ]
            .map(([e, t]) => `<div><dt>${e}</dt><dd>${t}</dd></div>`)
            .join(``);
    }
    function Se() {
        let e = O(),
            t = A();
        ([
            e?.name ?? `Not chosen`,
            `${me(k())} · ${E(t.eligible.length)}`,
            e ? (U(e.body) ? Pe(U(e.body), `variable`) : `None to fill`) : `—`,
            d.when === `now` ? `Send now` : `Scheduled`,
        ].forEach((e, t) => {
            b(`[data-sum="${t + 1}"]`, g).textContent = e;
        }),
            i(`.cp-steps__btn`, g).forEach((e, t) => {
                let n = t + 1;
                (e.classList.toggle(`is-done`, n < d.step && !M(n)),
                    n === d.step ? e.setAttribute(`aria-current`, `step`) : e.removeAttribute(`aria-current`));
            }));
    }
    function Ce(e) {
        ie(T, w, z(`.cp-steps__btn[data-step="${d.step}"]`, g), e, 16);
    }
    function W(e = 0, t = !0) {
        let r = mt[d.step - 1];
        ((b(`[data-stepn]`, g).textContent = `Step ${d.step} of 4`),
            (b(`[data-steptitle]`, g).textContent = r.title),
            (b(`[data-stepsub]`, g).textContent = r.sub),
            (_.innerHTML = [ce, de, B, he][d.step - 1]()),
            d.step === 2 && pe(!1),
            (v.textContent = ``),
            (b(`[data-back]`, g).hidden = d.step === 1));
        let a = b(`[data-next]`, g);
        (a.classList.toggle(`btn--wa`, d.step === 4 && d.when === `now`),
            a.classList.toggle(`btn--primary`, !(d.step === 4 && d.when === `now`)),
            (a.innerHTML =
                d.step < 4
                    ? `<span>Continue</span>${f(`chevR`)}`
                    : d.when === `now`
                      ? `${f(`send`)}<span>Send to ${E(A().eligible.length)}</span>`
                      : `${f(`clock`)}<span>Schedule broadcast</span>`),
            Se(),
            Ce(t),
            t &&
                !h() &&
                (n([..._.children], { x: e * 22, y: e ? 0 : 10, stagger: 0.05 }),
                C.fromTo(
                    i(`.cp-panel__head > *`, g),
                    { opacity: 0, y: 8 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: y(0.4),
                        stagger: y(0.04),
                        ease: `power3.out`,
                        clearProps: `transform,opacity`,
                    },
                )));
    }
    function G(e) {
        if (e === d.step) return;
        if (e > d.step) {
            let t = oe(e);
            if (t) {
                if (t !== d.step) {
                    let e = t > d.step ? 1 : -1;
                    ((d.step = t), W(e));
                }
                ((v.textContent = M(t) ?? ``), K());
                return;
            }
        }
        let t = e > d.step ? 1 : -1;
        ((d.step = e),
            W(t),
            matchMedia(`(max-width: 1180px)`).matches &&
                b(`.cp-panel`, g).scrollIntoView({ block: `nearest`, behavior: h() ? `auto` : `smooth` }),
            b(`[data-steptitle]`, g).focus({ preventScroll: !0 }));
    }
    function K() {
        h() || C.fromTo(v, { x: -6 }, { x: 0, duration: 0.5, ease: `elastic.out(1.2, 0.3)`, clearProps: `transform` });
    }
    function q(e = !1) {
        let t = O(),
            n = b(`[data-cap]`, x);
        if (!t) {
            (Ne(
                x,
                `<div class="bubble bubble--in cp-bubble cp-bubble--empty">${f(`template`)}<span>Pick a template to see it here.</span></div>`,
                e,
            ),
                (n.innerHTML = `Patients see the message from your verified business number.`));
            return;
        }
        let r = j();
        Ne(x, je(t, ke(d.maps.map((e) => ve(e, r)))), e);
        let i = A().eligible.length > 1;
        n.innerHTML = r
            ? `<span>Previewing as <b>${P(re(r))}</b></span>${i && U(t.body) ? `<button type="button" class="btn btn--xs btn--ghost" data-as>${f(`refresh`)}Next patient</button>` : ``}`
            : ``;
    }
    (g.addEventListener(`change`, (e) => {
        let t = e.target;
        if (((m = !0), t.name === `cp-tpl`)) {
            d.templateId = t.value;
            let e = O();
            ((d.maps = ye(e)), d.nameEdited || (d.name = _t(e.name)), (v.textContent = ``), q(!0), Se());
        } else if (t.name === `cp-aud` || t.name === `cp-tag`) {
            if (t.name === `cp-aud`) d.kind = t.value;
            else {
                ((d.tag = t.value), (d.kind = `tag`));
                let e = z(`input[name="cp-aud"][value="tag"]`, _);
                e && (e.checked = !0);
            }
            let e = b(`[data-tags]`, _);
            (d.kind === `tag` && e.hidden
                ? ((e.hidden = !1), n(i(`.cp-tagopt`, e), { y: 8, stagger: 0.03 }))
                : d.kind !== `tag` && (e.hidden = !0),
                (b(`[data-kn="tag"]`, _).textContent = E(H(d.tag).eligible.length)),
                (d.asIdx = 0),
                (v.textContent = ``),
                pe(!0),
                q(),
                Se());
        } else if (t.dataset.map !== void 0) {
            let e = Number(t.dataset.map),
                r = d.maps[e];
            r.src = t.value;
            let i = t.closest(`.cp-map`),
                a = b(`.cp-map__text`, i),
                o = b(`.cp-map__eg`, i);
            if (((a.hidden = r.src !== `text`), (o.hidden = r.src === `text`), r.src === `text`))
                ((r.text ||= O()?.sample[e] ?? ``), (b(`input`, a).value = r.text), n([a], { y: 6 }));
            else {
                let e = j();
                ((b(`[data-eg]`, o).textContent = ve(r, e)), n([o], { y: 6 }));
            }
            q();
        } else if (t.name === `cp-when`) {
            d.when = t.value;
            let e = b(`[data-sched]`, _);
            ((e.hidden = d.when !== `later`), e.hidden || n([...e.children], { y: 8 }), Ee());
        } else
            t.matches(`[data-date], [data-time]`) &&
                ((d.date = b(`[data-date]`, _).value), (d.time = b(`[data-time]`, _).value), Ee());
    }),
        g.addEventListener(`input`, (e) => {
            let t = e.target;
            ((m = !0),
                t.dataset.mtext === void 0
                    ? t.matches(`[data-name]`)
                        ? ((d.name = t.value), (d.nameEdited = !0))
                        : t.matches(`[data-date], [data-time]`) &&
                          ((d.date = b(`[data-date]`, _).value), (d.time = b(`[data-time]`, _).value), Ee())
                    : ((d.maps[Number(t.dataset.mtext)].text = t.value), q()));
        }));
    function Ee() {
        ((b(`[data-quiet]`, _).hidden = !be()), (b(`[data-sumlist]`, _).innerHTML = xe()));
        let e = b(`[data-next]`, g);
        (e.classList.toggle(`btn--wa`, d.when === `now`),
            e.classList.toggle(`btn--primary`, d.when !== `now`),
            (e.innerHTML =
                d.when === `now`
                    ? `${f(`send`)}<span>Send to ${E(A().eligible.length)}</span>`
                    : `${f(`clock`)}<span>Schedule broadcast</span>`),
            Se());
    }
    g.addEventListener(`click`, async (e) => {
        let n = e.target,
            r = n.closest(`[data-step]`);
        if (r) {
            G(Number(r.dataset.step));
            return;
        }
        if (n.closest(`[data-back]`)) {
            G(d.step - 1);
            return;
        }
        if (n.closest(`[data-as]`)) {
            ((d.asIdx += 1),
                ne(n.closest(`[data-as]`)),
                q(),
                d.step === 3 &&
                    i(`[data-eg]`, _).forEach((e) => {
                        e.textContent = ve(d.maps[Number(e.dataset.eg)], j());
                    }));
            return;
        }
        if (n.closest(`[data-next]`)) {
            let e = M(d.step);
            if (e) {
                ((v.textContent = e), K());
                return;
            }
            if (d.step < 4) {
                G(d.step + 1);
                return;
            }
            De(d.when === `now` ? `send` : `schedule`);
            return;
        }
        if (n.closest(`[data-draft]`)) {
            De(`draft`);
            return;
        }
        if (n.closest(`[data-cancel]`) || n.closest(`.head__back`)) {
            if (
                (n.closest(`.head__back`) && e.preventDefault(),
                m && !(await t(`Discard this broadcast?`, `Nothing has been sent. Your choices are lost.`, `Discard`)))
            )
                return;
            location.hash = `#/campaigns`;
        }
    });
    async function De(e) {
        let n = O();
        if (e === `draft`) {
            if (!n) {
                ((v.textContent = `Choose a template before saving a draft.`), K());
                return;
            }
        } else {
            let e = oe(5);
            if (e) {
                (e !== d.step && ((d.step = e), W(-1)), (v.textContent = M(e) ?? ``), K());
                return;
            }
        }
        let r = A();
        if (
            e === `send` &&
            !(await t(
                `Send to ${Pe(r.eligible.length, `patient`)} now?`,
                `${n.name} goes out on WhatsApp right away. This can’t be undone.`,
                `Send now`,
                !1,
            ))
        )
            return;
        let i = d.name.trim() || _t(n.name),
            o =
                ((e === `schedule` || (e === `draft` && d.when === `later`)) &&
                    new Date(`${d.date}T${d.time}`).getTime()) ||
                Date.now(),
            s = a ?? { id: ue(`b`), stats: { sent: 0, delivered: 0, read: 0, replied: 0, failed: 0, booked: 0 } };
        (Object.assign(s, {
            name: i,
            templateId: n.id,
            audience: k(),
            status: e === `schedule` ? `scheduled` : `draft`,
            at: o,
            recipients: e === `draft` ? 0 : r.eligible.length,
            excluded: e === `draft` ? 0 : r.excluded,
            vars: d.maps.map((e) => ({ ...e })),
        }),
            a || L.campaigns.unshift(s),
            R(
                `campaign`,
                e === `schedule` ? `scheduled ${i}` : e === `draft` ? `saved the draft ${i}` : `created ${i}`,
            ),
            V(`campaigns`, `activity`),
            (m = !1),
            e === `send`
                ? Ze(s, null)
                : D(e === `schedule` ? `“${i}” scheduled for ${S(o)}` : `Draft “${i}” saved`, {
                      ico: e === `schedule` ? `clock` : `note`,
                  }),
            (location.hash = `#/campaigns`));
    }
    return (
        W(0, !1),
        q(!1),
        new ResizeObserver(() => Ce(!1)).observe(w),
        s(g),
        {
            el: g,
            enter() {
                let e = te(g);
                if (
                    (n(i(`.cp-steps__btn`, g), { x: -14, y: 0, stagger: 0.06, delay: 0.1 }),
                    C.fromTo(T, { opacity: 0 }, { opacity: 1, duration: y(0.4), delay: y(0.35) }),
                    ee([b(`.cp-panel`, g)], { delay: 0.12 }),
                    n([..._.children], { y: 12, stagger: 0.05, delay: 0.3 }),
                    !h())
                ) {
                    C.fromTo(
                        b(`.cp-phone__frame`, x),
                        { opacity: 0, y: 60, rotation: 3 },
                        {
                            opacity: 1,
                            y: 0,
                            rotation: 0,
                            duration: y(1),
                            ease: `power4.out`,
                            delay: y(0.2),
                            clearProps: `transform,opacity`,
                        },
                    );
                    let e = z(`[data-slot] > *`, x);
                    e &&
                        C.fromTo(
                            e,
                            { opacity: 0, y: 14, scale: 0.92, transformOrigin: `0% 0%` },
                            {
                                opacity: 1,
                                y: 0,
                                scale: 1,
                                duration: y(0.6),
                                ease: `back.out(1.7)`,
                                delay: y(0.75),
                                clearProps: `transform,opacity`,
                            },
                        );
                }
                return (requestAnimationFrame(() => Ce(!1)), e);
            },
        }
    );
}
var X = { name: 512, header: 60, body: 1024, footer: 60, button: 25 },
    bt = `Reply STOP to opt out.`;
function xt(e, r) {
    let a = r[1] === `edit` || r[1] === `copy` ? r[1] : `new`,
        o = a === `new` ? void 0 : L.templates.find((e) => e.id === r[2]),
        c = a === `edit` && o && o.status !== `pending` ? o : void 0,
        l = o
            ? {
                  name:
                      a === `copy`
                          ? ((e) => {
                                let t = `${e}_copy`,
                                    n = 2;
                                for (; L.templates.some((e) => e.name === t); ) t = `${e}_copy_${n++}`;
                                return t;
                            })(o.name)
                          : o.name,
                  category: o.category,
                  lang: o.lang,
                  header: o.header ?? ``,
                  body: o.body,
                  footer: o.footer ?? ``,
                  buttons: [...o.buttons],
                  sample: [...o.sample],
              }
            : {
                  name: ``,
                  category: `utility`,
                  lang: `en_US`,
                  header: ``,
                  body: ``,
                  footer: ``,
                  buttons: [],
                  sample: [],
              },
        u = !1,
        d = !!o,
        m = c ? `Edit & resubmit` : a === `copy` ? `Duplicate template` : `New template`,
        g = document.createElement(`div`);
    g.className = `cp-focus cp-build`;
    let _ = (e) => `<span class="cp-count" data-count-of="${e}">${l[e].length} / ${X[e]}</span>`;
    ((g.innerHTML = `${p({ title: m, eyebrow: `Campaigns · WhatsApp template`, back: `#/campaigns/templates` })}
    <div class="cp-bld">
      <form class="card cp-form" novalidate aria-label="${P(m)}">
        ${c?.status === `rejected` && c.reason ? `<p class="note cp-note--bad">${f(`alert`)}<span><b>Why Meta rejected it.</b> ${P(c.reason)}</span></p>` : ``}
        <section class="cp-sec">
          <h2 class="cp-sec__t">Basics</h2>
          <div class="cp-row2">
            <label class="field"><span class="field__label">Name</span><input data-f="name" class="cp-mono-in" value="${P(l.name)}" maxlength="${X.name}" spellcheck="false" autocapitalize="off" autocomplete="off" placeholder="e.g. vaccine_reminder" aria-describedby="cp-name-hint" ${c ? `readonly` : ``} /><span class="field__hint" id="cp-name-hint" data-namehint>${c ? `A resubmitted template keeps its name.` : `Lowercase letters, numbers and underscores.`}</span></label>
            <label class="field"><span class="field__label">Language</span><select data-f="lang">${K.map(([e, t]) => `<option value="${e}" ${l.lang === e ? `selected` : ``}>${P(t)}</option>`).join(``)}</select></label>
          </div>
        </section>
        <section class="cp-sec">
          <h2 class="cp-sec__t">Category</h2>
          <fieldset class="cp-opts cp-opts--cat"><legend class="sr">Category</legend>${[`utility`, `marketing`, `authentication`].map((e) => `<label class="cp-opt cp-copt"><input class="sr" type="radio" name="cp-cat" value="${e}" ${l.category === e ? `checked` : ``} /><b>${k[e]}</b><small>${P(we[e])}</small><span class="cp-opt__tick" aria-hidden="true">${f(`check`)}</span></label>`).join(``)}</fieldset>
        </section>
        <section class="cp-sec">
          <h2 class="cp-sec__t">Message</h2>
          <label class="field"><span class="cp-flabel"><span class="field__label">Header <small>optional</small></span>${_(`header`)}</span><input data-f="header" value="${P(l.header)}" maxlength="${X.header}" autocomplete="off" placeholder="e.g. Your results are ready" /></label>
          <div class="field">
            <span class="cp-flabel"><label class="field__label" for="cp-body">Body</label>${_(`body`)}</span>
            <textarea id="cp-body" data-f="body" rows="6" maxlength="${X.body}" placeholder="Hi {{1}}, …">${P(l.body)}</textarea>
            <span class="cp-bodytools"><button type="button" class="btn btn--xs btn--soft" data-addvar>${f(`plus`)}Add variable</button><span class="field__hint">Variables are filled per patient: {{1}}, {{2}}…</span></span>
          </div>
          <label class="field"><span class="cp-flabel"><span class="field__label">Footer <small>optional</small></span>${_(`footer`)}</span><input data-f="footer" value="${P(l.footer)}" maxlength="${X.footer}" autocomplete="off" placeholder="e.g. ${P(bt)}" /></label>
          <p class="cp-optout" data-optout hidden><button type="button" class="btn btn--xs btn--ghost" data-addoptout>${f(`plus`)}Add “${P(bt)}”</button></p>
        </section>
        <section class="cp-sec">
          <h2 class="cp-sec__t">Quick replies <small>up to 3</small></h2>
          <div class="cp-btns" data-btns></div>
          <button type="button" class="btn btn--sm btn--ghost cp-addbtn" data-addbtn>${f(`plus`)}Add a button</button>
        </section>
        <section class="cp-sec" data-samplesec>
          <h2 class="cp-sec__t">Sample values</h2>
          <p class="cp-sec__sub">Meta reviews the template with these. Use realistic, non-personal examples.</p>
          <div class="cp-samples" data-samples></div>
        </section>
        <section class="cp-sec">
          <h2 class="cp-sec__t">Before you submit</h2>
          <ul class="cp-checks" data-checks aria-live="polite"></ul>
        </section>
        <p class="cp-err" role="alert" data-err></p>
        <footer class="cp-form__foot">
          <button type="button" class="btn btn--ghost" data-cancel>Cancel</button>
          <button type="submit" class="btn btn--primary magnetic">${f(`send`)}<span>Submit for review</span></button>
        </footer>
      </form>
      <aside class="cp-preview" aria-label="Preview">${Me(`How patients see this template`)}</aside>
    </div>`),
        e.replaceChildren(g));
    let v = b(`form`, g),
        x = b(`.cp-phone`, g),
        S = b(`[data-err]`, g),
        w = b(`[data-f="body"]`, g);
    function T() {
        ((b(`[data-btns]`, g).innerHTML = l.buttons
            .map(
                (e, t) =>
                    `<div class="cp-btnrow"><span class="cp-btnrow__ico" aria-hidden="true">${f(`reply`)}</span><label class="sr" for="cp-btn-${t}">Button ${t + 1}</label><input id="cp-btn-${t}" data-btn="${t}" value="${P(e)}" maxlength="${X.button}" placeholder="e.g. Book now" autocomplete="off" />${le(`trash`, `Remove button ${t + 1}`, `data-rmbtn="${t}"`, `ibtn--sm ibtn--plain`)}</div>`,
            )
            .join(``)),
            (b(`[data-addbtn]`, g).hidden = l.buttons.length >= 3));
    }
    function E() {
        let e = U(l.body);
        l.sample.length = Math.max(l.sample.length, e);
        let t = b(`[data-samples]`, g),
            r = i(`[data-sample]`, t).length;
        r !== e &&
            ((t.innerHTML = e
                ? Array.from(
                      { length: e },
                      (e, t) =>
                          `<label class="cp-sample"><span class="cp-var cp-var--lg">{{${t + 1}}}</span><span class="sr">Sample for {{${t + 1}}}</span><input data-sample="${t}" value="${P(l.sample[t] ?? ``)}" maxlength="60" autocomplete="off" placeholder="${t === 0 ? `e.g. Amina` : `Sample value`}" /></label>`,
                  ).join(``)
                : `<p class="cp-sec__sub cp-none">${f(`info`)}No variables yet. Use <b>Add variable</b> to personalise the body.</p>`),
            e > r && r > 0 && n(i(`.cp-sample`, t).slice(r), { y: 8 }));
    }
    function re() {
        let e = [],
            t = L.templates.some((e) => e.name === l.name && e !== c);
        (e.push({
            ok: xe.test(l.name) && !t,
            text: l.name
                ? t
                    ? `${l.name} is already taken`
                    : xe.test(l.name)
                      ? `Name uses lowercase and underscores`
                      : `Name: lowercase letters, numbers and underscores only`
                : `Name the template`,
        }),
            e.push({ ok: !!l.body.trim(), text: l.body.trim() ? `Body written` : `Write the message body` }));
        let n = be(l.body).sort((e, t) => e - t),
            r = n.every((e, t) => e === t + 1);
        n.length &&
            e.push({
                ok: r,
                text: r
                    ? `Variables run {{1}}, {{2}}… with no gaps`
                    : `Variables must run {{1}}, {{2}}… with no gaps (found ${n.map((e) => `{{${e}}}`).join(`, `)})`,
            });
        let i = U(l.body);
        if (i) {
            let t = Array.from({ length: i }, (e, t) => t).filter((e) => !l.sample[e]?.trim());
            e.push({
                ok: !t.length,
                text: t.length
                    ? `Add a sample for ${t.map((e) => `{{${e + 1}}}`).join(`, `)}`
                    : `A sample for every variable`,
            });
        }
        if (l.category === `utility`) {
            let t = Ce(l);
            e.push(
                t.length
                    ? {
                          ok: !1,
                          warn: !0,
                          text: `Reads as promotional: “${t.join(`”, “`)}”. Meta rejects offers in a Utility template.`,
                      }
                    : { ok: !0, text: `No promotional wording` },
            );
        }
        (l.category === `marketing` &&
            e.push({
                ok: G(l),
                text: G(l) ? `Patients can opt out` : `Add a way to opt out: a STOP footer or a Stop button`,
            }),
            l.category === `authentication` &&
                e.push({
                    ok: i === 1 && !l.header.trim(),
                    text:
                        i === 1 && !l.header.trim()
                            ? `One variable: the code`
                            : `Login codes have exactly one variable, {{1}}, and no header`,
                }));
        let a = l.buttons.findIndex((e) => !e.trim()),
            o = new Set(l.buttons.map((e) => e.trim().toLowerCase())).size !== l.buttons.length;
        return (
            l.buttons.length &&
                e.push({
                    ok: a < 0 && !o,
                    text:
                        a >= 0
                            ? `Button ${a + 1} needs a label`
                            : o
                              ? `Two buttons have the same label`
                              : `Buttons labelled`,
                }),
            e
        );
    }
    let O = ``;
    function A() {
        let e = re()
            .map(
                (e) =>
                    `<li class="cp-check ${e.ok ? `is-ok` : e.warn ? `is-warn` : `is-bad`}"><span class="cp-check__ico" aria-hidden="true">${f(e.ok ? `check` : e.warn ? `alert` : `close`)}</span><span>${P(e.text)}</span></li>`,
            )
            .join(``);
        if (e === O) return;
        let t = b(`[data-checks]`, g),
            n = i(`.cp-check`, t).map((e) => e.className);
        ((t.innerHTML = e),
            (O = e),
            i(`.cp-check`, t).forEach((e, t) => {
                n[t] &&
                    n[t] !== e.className &&
                    !h() &&
                    C.fromTo(
                        b(`.cp-check__ico`, e),
                        { scale: 0.5 },
                        { scale: 1, duration: 0.5, ease: `back.out(3)`, clearProps: `transform` },
                    );
            }));
    }
    function j() {
        [`header`, `body`, `footer`].forEach((e) => {
            let t = b(`[data-count-of="${e}"]`, g);
            ((t.textContent = `${l[e].length} / ${X[e]}`), t.classList.toggle(`is-near`, l[e].length > X[e] * 0.9));
        });
    }
    function ie() {
        let e = b(`[data-optout]`, g),
            t = l.category === `marketing` && !G(l);
        t && e.hidden ? ((e.hidden = !1), n([e], { y: 6 })) : t || (e.hidden = !0);
    }
    let M = ``;
    function ae(e = !1) {
        let t = je({ header: l.header, body: l.body, footer: l.footer, buttons: l.buttons }, ke(l.sample));
        ((t !== M || e) && (Ne(x, t, e), (M = t)),
            (b(`[data-cap]`, x).innerHTML =
                `<span>${l.category === `marketing` ? `${f(`shield`)}Sent only to patients who opted in` : `${f(`info`)}Samples shown as highlighted values`}</span>`));
    }
    function N() {
        (E(), A(), j(), ie(), ae());
    }
    return (
        v.addEventListener(`input`, (e) => {
            let t = e.target;
            u = !0;
            let n = t.dataset.f;
            if (n === `name`) {
                let e = t.selectionStart,
                    n = t.value.toLowerCase().replace(/[\s-]/g, `_`);
                (n !== t.value && ((t.value = n), e !== null && t.setSelectionRange(e, e)),
                    (l.name = t.value),
                    (d = !0));
            } else
                n === `header` || n === `body` || n === `footer`
                    ? (l[n] = t.value)
                    : t.dataset.btn === void 0
                      ? t.dataset.sample !== void 0 && (l.sample[Number(t.dataset.sample)] = t.value)
                      : (l.buttons[Number(t.dataset.btn)] = t.value);
            N();
        }),
        v.addEventListener(`change`, (e) => {
            let t = e.target;
            ((u = !0),
                t.name === `cp-cat`
                    ? ((l.category = t.value),
                      l.category === `authentication` &&
                          !l.body.trim() &&
                          ((l.body = `{{1}} is your verification code. For your security, do not share this code.`),
                          (w.value = l.body),
                          (l.sample[0] = l.sample[0] || `482913`),
                          l.buttons.length || ((l.buttons = [`Copy code`]), T())),
                      N())
                    : t.dataset.f === `lang` && (l.lang = t.value));
        }),
        v.addEventListener(`click`, async (e) => {
            let t = e.target;
            if (t.closest(`[data-addvar]`)) {
                let e = `{{${U(l.body) + 1}}}`,
                    n = w.selectionStart ?? l.body.length,
                    r = w.selectionEnd ?? n,
                    i = l.body.slice(0, n),
                    a = (i && !/\s$/.test(i) ? ` ` : ``) + e;
                (w.setRangeText(a, n, r, `end`),
                    w.focus(),
                    (l.body = w.value),
                    (u = !0),
                    ne(t.closest(`[data-addvar]`)),
                    N());
                let o = z(`[data-slot] .cp-var:last-of-type, [data-slot] .cp-fill:last-of-type`, x);
                o &&
                    !h() &&
                    C.fromTo(
                        o,
                        { scale: 0.4 },
                        { scale: 1, duration: 0.5, ease: `back.out(3)`, clearProps: `transform` },
                    );
                return;
            }
            if (t.closest(`[data-addoptout]`)) {
                let e = b(`[data-f="footer"]`, g);
                ((l.footer = l.footer.trim() ? `${l.footer.trim()} ${bt}`.slice(0, X.footer) : bt),
                    (e.value = l.footer),
                    (u = !0),
                    N());
                return;
            }
            if (t.closest(`[data-addbtn]`)) {
                if (l.buttons.length >= 3) return;
                (l.buttons.push(``), (u = !0), T(), N());
                let e = i(`.cp-btnrow`, g);
                (n(e.slice(-1), { y: 8 }), z(`[data-btn]:last-of-type`, e[e.length - 1])?.focus());
                return;
            }
            let r = t.closest(`[data-rmbtn]`);
            if (r) {
                let e = Number(r.dataset.rmbtn),
                    t = r.closest(`.cp-btnrow`);
                C.to(t, {
                    opacity: 0,
                    x: 14,
                    duration: y(0.2),
                    ease: `power2.in`,
                    onComplete: () => {
                        (l.buttons.splice(e, 1), (u = !0), T(), N());
                    },
                });
                return;
            }
        }),
        g.addEventListener(`click`, async (e) => {
            let n = e.target;
            (!n.closest(`[data-cancel]`) && !n.closest(`.head__back`)) ||
                (e.preventDefault(),
                !(u && !(await t(`Discard this template?`, `Nothing was sent to Meta.`, `Discard`))) &&
                    (location.hash = `#/campaigns/templates`));
        }),
        v.addEventListener(`submit`, (e) => {
            e.preventDefault();
            let t = re().find((e) => !e.ok && !e.warn);
            if (t) {
                ((S.textContent = t.text.replace(/^Name:/, `Name must use`)),
                    h() ||
                        C.fromTo(
                            S,
                            { x: -6 },
                            { x: 0, duration: 0.5, ease: `elastic.out(1.2, 0.3)`, clearProps: `transform` },
                        ),
                    b(`[data-checks]`, g).scrollIntoView({ block: `center`, behavior: h() ? `auto` : `smooth` }),
                    !d && /name/i.test(t.text) && b(`[data-f="name"]`, g).focus());
                return;
            }
            let n = U(l.body),
                r = {
                    name: l.name,
                    category: l.category,
                    lang: l.lang,
                    body: l.body.trim(),
                    buttons: l.buttons.map((e) => e.trim()).filter(Boolean),
                    sample: l.sample.slice(0, n).map((e) => e.trim()),
                    ...(l.header.trim() ? { header: l.header.trim() } : {}),
                    ...(l.footer.trim() ? { footer: l.footer.trim() } : {}),
                },
                i;
            (c
                ? ((i = c), delete i.header, delete i.footer, Object.assign(i, r))
                : ((i = { id: ue(`tp`), status: `pending`, sent: 0, read: 0, replied: 0, updated: Date.now(), ...r }),
                  L.templates.unshift(i)),
                Y.stat !== `all` && Y.stat !== `pending` && (Y.stat = `all`),
                Y.cat !== `all` && Y.cat !== i.category && (Y.cat = `all`),
                (u = !1),
                dt(i),
                D(`${i.name} sent to Meta for review`, { ico: `send` }),
                (location.hash = `#/campaigns/templates`));
        }),
        T(),
        N(),
        s(g),
        {
            el: g,
            enter() {
                if (
                    (te(g), ee([v], { delay: 0.08 }), n(i(`.cp-sec`, v), { y: 14, stagger: 0.05, delay: 0.25 }), !h())
                ) {
                    C.fromTo(
                        b(`.cp-phone__frame`, x),
                        { opacity: 0, y: 60, rotation: 3 },
                        {
                            opacity: 1,
                            y: 0,
                            rotation: 0,
                            duration: y(1),
                            ease: `power4.out`,
                            delay: y(0.2),
                            clearProps: `transform,opacity`,
                        },
                    );
                    let e = z(`[data-slot] > *`, x);
                    e &&
                        C.fromTo(
                            e,
                            { opacity: 0, y: 14, scale: 0.92, transformOrigin: `0% 0%` },
                            {
                                opacity: 1,
                                y: 0,
                                scale: 1,
                                duration: y(0.6),
                                ease: `back.out(1.7)`,
                                delay: y(0.75),
                                clearProps: `transform,opacity`,
                            },
                        );
                }
                !o &&
                    matchMedia(`(pointer: fine)`).matches &&
                    requestAnimationFrame(() => b(`[data-f="name"]`, g).focus({ preventScroll: !0 }));
            },
        }
    );
}
var St = (e) =>
        e[0] === `templates`
            ? e[1] === `new` || e[1] === `edit` || e[1] === `copy`
                ? `build`
                : `templates`
            : e[0] === `new` || e[0] === `edit`
              ? `compose`
              : `broadcasts`,
    Ct = (e) => e === `broadcasts` || e === `templates`,
    Z,
    Q = null,
    $ = null,
    wt = null,
    Tt = !1;
function Et() {
    let e = L.templates.reduce((e, t) => e + t.sent, 0),
        t = L.templates.reduce((e, t) => e + t.read, 0),
        n = L.templates.reduce((e, t) => e + t.replied, 0),
        r = L.campaigns.reduce((e, t) => e + t.stats.booked, 0);
    return { sent: e, read: e ? t / e : 0, reply: e ? n / e : 0, booked: r };
}
function Dt() {
    let e = Et();
    return [
        { icon: `send`, value: e.sent, label: `Messages sent`, key: `sent` },
        { icon: `eye`, value: e.read, fmt: `pct`, label: `Read rate`, key: `read` },
        { icon: `reply`, value: e.reply, fmt: `pct`, label: `Reply rate`, key: `reply` },
        { icon: `calCheck`, value: e.booked, label: `Bookings from broadcasts`, key: `booked` },
    ];
}
function Ot() {
    if (!$) return;
    let e = Et();
    (O(z(`[data-stat="sent"] b`, $), e.sent),
        O(z(`[data-stat="read"] b`, $), e.read),
        O(z(`[data-stat="reply"] b`, $), e.reply),
        O(z(`[data-stat="booked"] b`, $), e.booked));
    let t = z(`[data-countline]`, $);
    t && (t.textContent = pt());
}
var kt = [
        [`all`, `All`],
        [`utility`, `Utility`],
        [`marketing`, `Marketing`],
        [`authentication`, `Authentication`],
    ],
    At = [
        [`all`, `All`],
        [`approved`, `Approved`],
        [`pending`, `Pending`],
        [`rejected`, `Rejected`],
    ],
    jt = null,
    Mt = null;
function Nt(e) {
    let t = document.createElement(`div`);
    ((t.className = `cp-list`),
        (t.innerHTML = `${p({ title: `Campaigns`, eyebrow: `WhatsApp broadcasts and templates`, stats: Dt(), actions: `<a class="btn btn--ghost" href="#/campaigns/templates/new">${f(`template`)}<span>New template</span></a><a class="btn btn--primary magnetic" href="#/campaigns/new">${f(`megaphone`)}<span>New broadcast</span></a>` })}
    <div class="cp-bar">
      <div class="cp-bar__tabs">${j(
          `Campaigns view`,
          [
              [`broadcasts`, `Broadcasts`],
              [`templates`, `Templates`],
          ],
          e,
      )}<p class="cp-bar__line" data-countline ${e === `templates` ? `` : `hidden`}>${pt()}</p></div>
      <div class="cp-filters hfade" data-filters ${e === `templates` ? `` : `hidden`}>
        <span class="cp-filters__lab" aria-hidden="true">${f(`filter`)}</span>
        ${j(`Category`, kt, Y.cat)}
        ${j(`Status`, At, Y.stat)}
      </div>
    </div>
    <div class="cp-body" data-body></div>`),
        Z.replaceChildren(t),
        ($ = t));
    let n = i(`.seg`, t);
    ((wt = oe(n[0], (e) => {
        location.hash = e === `templates` ? `#/campaigns/templates` : `#/campaigns`;
    })),
        (jt = oe(n[1], (e) => {
            ((Y.cat = e), Lt());
        })),
        (Mt = oe(n[2], (e) => {
            ((Y.stat = e), Lt());
        })));
    let r = b(`[data-body]`, t);
    (Ye(r, () => Ot()),
        lt(r, () => {
            ((Y.cat = `all`),
                (Y.stat = `all`),
                jt?.select(`all`, { silent: !0 }),
                Mt?.select(`all`, { silent: !0 }),
                Lt());
        }),
        Pt(e),
        s(t));
}
function Pt(e) {
    let t = b(`[data-body]`, $);
    ((t.dataset.which = e), (t.innerHTML = e === `broadcasts` ? qe() : ot()), e === `broadcasts` && J(t, !1), v(t, -3));
}
function Ft(e, t = 0) {
    let r = b(`[data-body]`, $);
    (e === `broadcasts`
        ? (a(i(`.cp-cast`, r), { delay: t, stagger: 0.07 }), J(r, !0, t + 0.35), Ke(r, t + 0.35))
        : (a(i(`.cp-tpl`, r), { delay: t, stagger: 0.045 }),
          n(i(`.cp-tpl .cp-bubble`, r), { y: 10, stagger: 0.045, delay: t + 0.3 })),
        n(i(`.empty`, r), { y: 12, delay: t }));
}
function It(e) {
    let t = b(`[data-body]`, $);
    wt?.select(e, { silent: !0 });
    let r = b(`[data-filters]`, $),
        i = b(`[data-countline]`, $);
    ((r.hidden = e !== `templates`),
        (i.hidden = e !== `templates`),
        e === `templates` &&
            (n([...r.children, i], { y: 8, stagger: 0.04 }),
            requestAnimationFrame(() => {
                (jt?.place(!1), Mt?.place(!1));
            })),
        C.killTweensOf(t),
        C.to(t, {
            opacity: 0,
            y: 8,
            duration: y(0.16),
            ease: `power2.in`,
            onComplete: () => {
                (C.set(t, { clearProps: `opacity,transform` }), Pt(e), Ft(e));
            },
        }));
}
function Lt() {
    let e = b(`[data-body]`, $);
    if (h()) {
        e.innerHTML = ot();
        return;
    }
    C.to(i(`.cp-tpl, .empty`, e), {
        opacity: 0,
        y: 6,
        scale: 0.98,
        duration: 0.14,
        stagger: 0.01,
        ease: `power2.in`,
        onComplete: () => {
            ((e.innerHTML = ot()), v(e, -3), a(i(`.cp-tpl`, e), { stagger: 0.035 }), n(i(`.empty`, e), { y: 10 }));
        },
    });
}
function Rt(e) {
    let t = St(e);
    ((Q = t),
        (Tt = !1),
        t === `compose`
            ? (($ = null), yt(Z, e).enter())
            : t === `build`
              ? (($ = null), xt(Z, e).enter())
              : (Nt(t),
                te($),
                n(
                    i(`.cp-bar > *`, $).filter((e) => !e.hidden),
                    { y: 10, stagger: 0.05, delay: 0.18 },
                ),
                Ft(t, 0.22)));
}
var zt = () => !Z.hidden && document.documentElement.dataset.route === `campaigns`,
    Bt = {
        title: (e) => {
            let t = St(e);
            return t === `compose`
                ? e[0] === `edit`
                    ? `Edit broadcast`
                    : `New broadcast`
                : t === `build`
                  ? e[1] === `edit`
                      ? `Edit template`
                      : `New template`
                  : t === `templates`
                    ? `Templates · Campaigns`
                    : `Campaigns`;
        },
        mount(e) {
            ((Z = e),
                rt(),
                A(`campaigns`, () => {
                    if (!zt() || !Ct(Q)) {
                        Tt = !0;
                        return;
                    }
                    (Ot(), !B.quiet && Q === `broadcasts` && $ && Je(b(`[data-body]`, $)));
                }),
                A(`templates`, () => {
                    if (!zt() || !Ct(Q)) {
                        Tt = !0;
                        return;
                    }
                    if ((Ot(), !$ || Q !== `templates`)) return;
                    let e = b(`[data-body]`, $);
                    B.quiet ? ct(e) : st(e);
                }));
        },
        enter({ params: e, same: t }) {
            let n = St(e);
            if (t && n === Q && !Ct(n)) {
                Vt(e);
                return;
            }
            if (t && Ct(Q) && Ct(n) && $ && !Tt) {
                n !== Q && ((Q = n), It(n));
                return;
            }
            if (t) {
                Vt(e);
                return;
            }
            Rt(e);
        },
        leave() {},
    };
function Vt(e) {
    (C.killTweensOf(Z),
        C.to(Z, {
            opacity: 0,
            y: -8,
            duration: h() ? 0 : 0.18,
            ease: `power2.in`,
            onComplete: () => {
                (C.set(Z, { clearProps: `opacity,transform` }),
                    window.scrollTo({ top: 0 }),
                    Rt(e),
                    r.v && z(`.head__title`, Z)?.focus({ preventScroll: !0 }));
            },
        }));
}
export { Bt as page };
