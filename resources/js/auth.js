
// resources/js/auth.js

import axios from 'axios';

export async function generateApiToken() {
  try {
    const response = await axios.post('/api/token');
    const token = response.data.token;

    localStorage.setItem('api_token', token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    console.log('API token set successfully');
  } catch (error) {
    console.error('Could not generate token:', error);
  }
}

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

