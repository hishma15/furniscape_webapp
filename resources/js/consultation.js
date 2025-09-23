// import axios from "axios";

import axios from 'axios';

// Get the token from localStorage (or your storage method)
const token = localStorage.getItem('api_token');

if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
} else {
  console.warn('No auth token found, requests will be unauthenticated');
}


// Run all JS after page load
document.addEventListener('DOMContentLoaded', () => {
  handleCustomerBooking();  // if form exists
  handleAdminConsultationTable(); // if admin page exists
  loadConsultations();
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

function handleAdminConsultationTable() {
    const table = document.getElementById('consultation-body');
    if (!table) return;

    axios.get('/api/consultations')
        .then(response => {
        const consultations = response.data.data;
        table.innerHTML = '';

        consultations.forEach((consultation, index) => {
            table.innerHTML += generateConsultationRow(consultation, index);
        });
    })
    .catch(error => {
      console.error(error);
      alert('Failed to load consultations.');
    });
}

function generateConsultationRow(consultation, index) {
    return `
        <tr>
        <td class="border px-4 py-2">${index + 1}</td>
        <td class="border px-4 py-2">${consultation.topic}</td>
        <td class="border px-4 py-2">${consultation.customer?.name ?? '-'}</td>
        <td class="border px-4 py-2">${consultation.mode}</td>
        <td class="border px-4 py-2">${consultation.description}</td>
        <td class="border px-4 py-2">${consultation.prefered_date}</td>
        <td class="border px-4 py-2">${consultation.prefered_time}</td>
        <td class="border px-4 py-2">${consultation.status}</td>
        <td class="border px-4 py-2">${getActions(consultation)}</td>
        </tr>
    `;
}

function getActions(consultation) {
  const currentStatus = consultation.status;
  const id = consultation.id;
  let buttons = '';

  if (currentStatus === 'pending') {
    buttons += `<button onclick="updateStatus('${id}', 'confirmed')" class="bg-blue-500 text-white px-2 py-1 rounded mr-1">Confirm</button>`;
    buttons += `<button onclick="updateStatus('${id}', 'cancelled')" class="bg-red-500 text-white px-2 py-1 rounded">Cancel</button>`;
  } else if (currentStatus === 'confirmed') {
    buttons += `<button onclick="updateStatus('${id}', 'completed')" class="bg-green-600 text-white px-2 py-1 rounded">Complete</button>`;
  }

  return buttons;
}

window.updateStatus = function (id, newStatus) {
  axios.put(`/api/consultations/${id}`, { status: newStatus })
    .then(() => {
      alert('Status updated!');
      location.reload();
    })
    .catch(handleError);
}

function handleError(error) {
  if (error.response && error.response.data.errors) {
    let messages = Object.values(error.response.data.errors).flat().join('\n');
    alert('Validation failed:\n' + messages);
  } else {
    alert('Something went wrong.');
    console.error(error);
  }

}
function loadConsultations(page = 1) {
  const table = document.getElementById('consultation-body');
  if (!table) return;

  axios.get(`/api/consultations?page=${page}`)
    .then(response => {
      const consultations = response.data.data;
      const meta = response.data.meta;

      table.innerHTML = '';
      consultations.forEach((consultation, index) => {
        table.innerHTML += generateConsultationRow(consultation, index);
      });

      renderPagination(meta);
    })
    .catch(error => {
      console.error(error);
      alert('Failed to load consultations.');
    });
}

function renderPagination(meta) {
  const paginationContainer = document.getElementById('pagination');
  if (!paginationContainer) return;

  paginationContainer.innerHTML = '';

  for (let page = 1; page <= meta.last_page; page++) {
    const button = document.createElement('button');
    button.textContent = page;
    button.className = `mx-1 px-3 py-1 rounded ${page === meta.current_page ? 'bg-brown text-white' : 'bg-gray-200'}`;

    button.addEventListener('click', () => loadConsultations(page));
    paginationContainer.appendChild(button);
  }
}




// document.addEventListener('DOMContentLoaded', () => {
//     const form = document.getElementById('consultation-form');

//     if (!form) return;

//     form.addEventListener('submit', async function (event) {
//         event.preventDefault();

//         // Prepare form data
//         const formData = new FormData(form);

//         const data = {
//             prefered_date: formData.get('prefered_date'),
//             prefered_time: formData.get('prefered_time'),
//             mode: formData.get('mode'),
//             topic: formData.get('topic'),
//             description: formData.get('description'),
//         };

//         try {
//             const response = await axios.post('api/consultations', data); // web.php route
//             alert('Consultation booked successfully!');
//             form.reset(); 
//         } catch (error) {
//             if (error.response && error.response.data.errors) {
//                 // Laravel validation errors
//                 let messages = Object.values(error.response.data.errors).flat().join('\n');
//                 alert('Validation failed:\n' + messages);
//             } else {
//                 alert('Failed to book consultation. Please try again.');
//                 console.error(error);
//             }
//         }
//     });
// });
