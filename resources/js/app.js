import './bootstrap';

fetch('/memory/finish', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify(payload),
})

function sendResultToServer(elapsedSeconds) {
    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    fetch('/memory/finish', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            elapsed_seconds: elapsedSeconds,
            level: GAME_LEVEL,
        }),
    })
        .then(async (res) => {
            if (!res.ok) {
                const text = await res.text();
                console.error('Server error:', res.status, text);
                return;
            }

            return res.json();
        })
        .then((data) => {
            console.log('Saved:', data);
        })
        .catch((err) => {
            console.error('Network error:', err);
        });
}

