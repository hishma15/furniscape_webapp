import './bootstrap';

import { generateApiToken } from './auth';

import './consultation';
import './products';

// import Alpine from 'alpinejs'

// window.Alpine = Alpine
// Alpine.start()

document.addEventListener('DOMContentLoaded', () => {
  const isLoggedIn = document.body.dataset.loggedIn === 'true'; // You can pass this from Blade

  if (isLoggedIn) {
    generateApiToken();
  }
});
