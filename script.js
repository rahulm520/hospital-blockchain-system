let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.navbar');

menu.onclick = () =>{
    menu.classList.toggle('fa-time');
    navbar.classList.toggle('active');
}

window.onscroll = () =>{
    menu.classList.remove('fa-time');
    navbar.classList.remove('active');
}

function changeImage() {
    document.getElementById("doctorImage").src = "assets/doctor-with-his-arms-crossed-white-background.jpg"; // Change to desired image path
  }

  //Fetching and managing Patient records
  document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const fetchRecordsForm = document.getElementById('fetchRecordsForm');
    const patientDataSection = document.getElementById('patient-data');
    
    patientDataSection.style.display = 'none';

    if (loginForm) {
        const patientBtn = document.getElementById("patientBtn");
        const doctorBtn = document.getElementById("doctorBtn");

        patientBtn.addEventListener("click", function() {
            loginForm.dataset.role = "patient";
            alert("Patient login selected");
        });

        doctorBtn.addEventListener("click", function() {
            loginForm.dataset.role = "doctor";
            alert("Doctor login selected");
        });

        loginForm.addEventListener("submit", async function(event) {
            event.preventDefault();
            const userType = loginForm.dataset.role;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                const response = await fetch('http://localhost:3000/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ userType, email, password })
                });
                const data = await response.json();
                console.log('Login response:', data);

                if (data.status === "success") {
                    if (userType === "doctor") {
                        alert("Doctor login successful");
                        window.location.href = 'doctor.html';
                    } else if (userType === "patient") {
                        alert("Patient login successful");
                        window.location.href = 'patient.html';
                    }
                } else {
                    alert("Login failed. Please check your credentials.");
                }
            } catch (error) {
                console.error('Login error:', error);
                alert("An error occurred. Please try again later.");
            }
        });
    }

    if (fetchRecordsForm) {
        fetchRecordsForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const patientAadhar = document.getElementById('patientAadhar').value;
            
            try {
                const response = await fetch(`http://localhost:3000/patient/${patientAadhar}`);
                const patient = await response.json();
                
                if (patient.error) {
                    alert(patient.error);
                    return;
                }
                
                document.getElementById('book').style.display = 'none';
                patientDataSection.style.display = 'block';
                
                document.getElementById('patient-name').innerText = patient.name;
                const historyList = document.getElementById('patient-history');
                historyList.innerHTML = '';
                patient.history.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.innerText = item;
                    historyList.appendChild(listItem);
                });
            } catch (error) {
                console.error('Fetch error:', error);
                alert('An error occurred while fetching patient data. Please try again later.');
            }
        });
    }
});