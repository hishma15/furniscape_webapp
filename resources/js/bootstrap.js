import axios from 'axios';
window.axios = axios;


// Set CSRF token header 
const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');
if (csrfTokenMeta) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfTokenMeta.content;
}

// Set Authorization header if token exists
const token = localStorage.getItem('api_token');
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}


// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// // Add CSRF token to Axios headers for all requests
// const token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//   window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//   console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }
