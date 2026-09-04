(function () {
    'use strict';

    var body = document.body;
    var cover = document.getElementById('invitationCover');
    var content = document.getElementById('invitationContent');
    var openButton = document.getElementById('openInvitationButton');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (body && cover && content && openButton) {
        body.classList.add('js-ready', 'invitation-locked');
        body.classList.toggle('motion-ready', !reducedMotion);
        content.setAttribute('aria-hidden', 'true');

        if (!reducedMotion) {
            createDecorations(body);
            prepareReveals();
        }

        openButton.addEventListener('click', function () {
            cover.classList.add('is-opened');
            content.classList.add('is-visible');
            content.setAttribute('aria-hidden', 'false');
            openButton.setAttribute('aria-expanded', 'true');
            body.classList.remove('invitation-locked');

            window.setTimeout(function () {
                cover.hidden = true;
                document.getElementById('opening')?.scrollIntoView({
                    behavior: reducedMotion ? 'auto' : 'smooth'
                });
            }, 700);
        });
    }

    function prepareReveals() {
        var sections = document.querySelectorAll('[data-reveal]');

        document.querySelectorAll('[data-stagger]').forEach(function (group) {
            Array.from(group.children).slice(0, 12).forEach(function (item, index) {
                item.style.setProperty('--stagger-index', index);
            });
        });

        if (!('IntersectionObserver' in window)) {
            sections.forEach(function (section) {
                section.classList.add('is-revealed');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -10% 0px',
            threshold: 0.12
        });

        sections.forEach(function (section) {
            observer.observe(section);
        });
    }

    function createDecorations(target) {
        var container = document.createElement('div');
        var count = window.matchMedia('(max-width: 600px)').matches ? 6 : 10;
        container.className = 'motion-decorations';
        container.setAttribute('aria-hidden', 'true');

        for (var index = 0; index < count; index += 1) {
            var decoration = document.createElement('span');
            decoration.style.setProperty('--decor-x', (8 + Math.random() * 84) + '%');
            decoration.style.setProperty('--decor-y', (5 + Math.random() * 90) + '%');
            decoration.style.setProperty('--decor-delay', (Math.random() * -8) + 's');
            decoration.style.setProperty('--decor-duration', (7 + Math.random() * 7) + 's');
            container.append(decoration);
        }

        target.prepend(container);
    }

    var countdown = document.querySelector('[data-target-date]');

    if (countdown) {
        var target = new Date(countdown.dataset.targetDate).getTime();
        var fields = {
            days: countdown.querySelector('[data-countdown="days"]'),
            hours: countdown.querySelector('[data-countdown="hours"]'),
            minutes: countdown.querySelector('[data-countdown="minutes"]'),
            seconds: countdown.querySelector('[data-countdown="seconds"]')
        };

        var timer;
        var updateCountdown = function () {
            var distance = Math.max(0, target - Date.now());

            fields.days.textContent = Math.floor(distance / 86400000);
            fields.hours.textContent = Math.floor(distance / 3600000 % 24);
            fields.minutes.textContent = Math.floor(distance / 60000 % 60);
            fields.seconds.textContent = Math.floor(distance / 1000 % 60);

            if (distance === 0 && timer) {
                window.clearInterval(timer);
            }
        };

        updateCountdown();
        timer = window.setInterval(updateCountdown, 1000);
    }

    var wishForm = document.querySelector('[data-wish-form]');

    if (!wishForm || !window.fetch || !window.FormData) {
        return;
    }

    var messageInput = wishForm.querySelector('[name="message"]');
    var counter = document.getElementById('messageCounter');
    var feedback = document.getElementById('wishFeedback');

    messageInput.addEventListener('input', function () {
        counter.textContent = messageInput.value.length + ' / 300 karakter';
    });

    wishForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        var submitButton = wishForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        feedback.className = 'wish-feedback';
        feedback.textContent = 'Mengirim ucapan...';

        try {
            var response = await fetch(wishForm.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(wishForm)
            });
            var payload = await response.json();

            if (!response.ok) {
                var errors = payload.errors ? Object.values(payload.errors).flat() : [];
                throw new Error(errors[0] || payload.message || 'Ucapan gagal dikirim.');
            }

            var card = document.createElement('article');
            var name = document.createElement('strong');
            var message = document.createElement('p');
            card.className = 'wish-preview-card new-wish';
            name.textContent = payload.wish.guest_name;
            message.textContent = payload.wish.message;
            card.append(name, message);

            document.querySelector('.wishes-empty')?.remove();
            document.getElementById('wishesList').prepend(card);
            wishForm.reset();
            counter.textContent = '0 / 300 karakter';
            feedback.classList.add('success');
            feedback.textContent = payload.message;
        } catch (error) {
            feedback.classList.add('error');
            feedback.textContent = error.message || 'Ucapan gagal dikirim. Coba lagi.';
        } finally {
            submitButton.disabled = false;
        }
    });
}());
