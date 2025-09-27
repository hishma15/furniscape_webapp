import axios from 'axios';

// axios.defaults.withCredentials = true;

axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.Laravel.apiToken;

document.addEventListener('DOMContentLoaded', async () => {
  try {
    await axios.get('/sanctum/csrf-cookie'); // Needed for session-based API access

    handleCustomerBooking();
  } catch (err) {
    // console.error('CSRF setup failed', err);

      console.error(error);

  const msgDiv = document.getElementById('form-messages');
  if (msgDiv) {
    if (error.response && error.response.data && error.response.data.message) {
      msgDiv.textContent = error.response.data.message;
    } else {
      msgDiv.textContent = 'An error occurred. Please try again.';
    }
  }

  alert('Failed to book consultation. Please try again.');
  
  }
});


function handleCustomerBooking() {
  const form = document.getElementById('consultation-form');
  if (!form) return;

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(form);
    const data = {
        prefered_date: formData.get('prefered_date'),
        prefered_time: formData.get('prefered_time'),
        mode: formData.get('mode'),
        topic: formData.get('topic'),
        description: formData.get('description'),
    };

    try {
        await axios.post('/api/consultations', data);
        alert('Consultation booked successfully!');
        form.reset();
    } catch (error) {
        handleError(error);
    }
  });
}

