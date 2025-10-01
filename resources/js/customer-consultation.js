import axios from 'axios';

// axios.defaults.withCredentials = true;

axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.Laravel.apiToken;

document.addEventListener('DOMContentLoaded', async () => {
  try {
    await axios.get('/sanctum/csrf-cookie'); // Needed for session-based API access

    handleCustomerBooking();

     //Hook into Livewire lifecycle to re-bind after DOM updates
    window.livewire?.hook('message.processed', () => {
      setupConsultationDeleteButtons();
    });

    setupConsultationDeleteButtons();

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
        // alert('Consultation booked successfully!');
        showNotification('Consultation booked successfully.', 'success');
        form.reset();
    } catch (error) {
        handleError(error);
    }
  });
}

function setupConsultationDeleteButtons() {
  const buttons = document.querySelectorAll('.delete-consultation-btn');
  console.log('Found consultation delete buttons:', buttons.length);

  buttons.forEach(button => {
    console.log('Binding click event to:', button);

    button.addEventListener('click', async () => {
      const consultationId = button.dataset.id;
      console.log('Clicked delete on consultation ID:', consultationId);

      if (!confirm('Are you sure you want to delete this consultation?')) return;

      try {
        await axios.delete(`/api/consultations/${consultationId}`);
        // alert('Consultation deleted successfully!');
        showNotification('Consultation deleted successfully.', 'success');
        location.reload();
      } catch (error) {
        console.error(error);
        alert(error?.response?.data?.message || 'Error deleting consultation.');
      }
    });
  });
}


