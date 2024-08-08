import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: pusherCluster ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${pusherCluster}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});

  window.Echo.channel('orderPlaced')
    .listen('RTOrderPlacedNotificationEvent', (e)=>{
        let html = ` <a href="/admin/order/${e.orderId}" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>${e.message}</b> Order have been placed.
                            <div class="time">${e.dates}</div>
                        </div>`;
        $('.rt-notification').prepend(html);
        $('.notification-beep').addClass('beep');
    });





