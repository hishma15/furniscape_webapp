
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


// axios.post('/api/login', { email, password })
//   .then(response => {
//     const token = response.data.token;
//     localStorage.setItem('api_token', token);
//     // Redirect or load dashboard
//   })
//   .catch(err => {
//     console.error('Login failed', err);
//   });


// export async function generateApiToken() {
//   try {
//     const response = await axios.post('/api/token');
//     const token = response.data.token;

//     localStorage.setItem('api_token', token);
//     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

//     console.log('API token set successfully');
//   } catch (error) {
//     console.error('Could not generate token:', error);
//   }
// }


///////////////////


// document.getElementById('login-form').addEventListener('submit', async function (e) {
//   e.preventDefault(); // prevent form from reloading page

//   const email = document.getElementById('email').value;
//   const password = document.getElementById('password').value;

//   try {
//     const response = await axios.post('/api/login', {
//       email,
//       password
//     });

//     const token = response.data.token;
//     localStorage.setItem('api_token', token);
//     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

//     console.log('Login successful');
//     // Redirect or update UI
//     window.location.href = '/dashboard'; // Or wherever
//   } catch (error) {
//     console.error('Login failed:', error.response.data.message);
//     alert('Login failed: ' + error.response.data.message);
//   }
// });



// // resources/js/auth.js
// import axios from 'axios';

// export async function login(email, password) {
//   try {
//     const response = await axios.post('/api/login', { email, password });
//     const token = response.data.token;

//     // Save token in localStorage
//     localStorage.setItem('api_token', token);

//     // Set default Authorization header for axios
//     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

//     console.log('Login successful, token stored.');
//     return true;
//   } catch (error) {
//     console.error('Login failed:', error);
//     return false;
//   }
// }

// export function logout() {
//   localStorage.removeItem('api_token');
//   delete axios.defaults.headers.common['Authorization'];
// }

