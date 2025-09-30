
// resources/js/auth.js

import axios from 'axios';

document.getElementById('admin-login-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await axios.post('/admin/login', {
            email: formData.get('email'),
            password: formData.get('password'),
        }, {
            headers: {
                Accept: 'application/json', // triggers expectsJson()
            }
        });

        localStorage.setItem('admin_api_token', response.data.token);
        console.log('Login successful!');
        window.location.href = '/admin/dashboard'; // or wherever you want
    } catch (error) {
        console.log('Login failed.');
        console.error(error);
    }
});


