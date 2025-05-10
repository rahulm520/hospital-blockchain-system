# 🏥 Blockchain-Integrated Medical Records System (ArogyaChain)

A full-stack decentralized web application (dApp) to securely store and audit medical records using **Ethereum blockchain**, **PHP backend**, and a **MySQL database**. Every record insertion is immutably logged on the blockchain and silently tracked in the backend with metadata like IP address, timestamp, and hospital.

---

## 🔧 Tech Stack

| Layer          | Tech Used                                        |
|----------------|--------------------------------------------------|
| 💻 Frontend     | HTML, CSS, JavaScript, Animate.css, Ethers.js    |
| 📦 Backend      | PHP, MySQL, XAMPP                                 |
| 🔗 Blockchain   | Solidity, Hardhat, MetaMask, Ethers.js            |
| 🗂️ Logging      | Custom logging table with geolocation and Tx hash |
| 🧪 Tools         | VS Code, Hardhat Node, Canva         |

---

## 🧠 Features

- ✅ **Aadhar-based patient lookup**
- ✅ **MetaMask-integrated medical record submission**
- ✅ **Blockchain-based treatment verification**
- ✅ **Backend database logging for audit trails**
- ✅ **Admin dashboard to review proof logs**
- ✅ **No duplicate or unauthorized access**
- ✅ **Silent forensic logging of actions**

---

## 📌 Blockchain Functionality

Every medical record added by a hospital is also written to the Ethereum blockchain (via a local Hardhat network) to ensure:
- Immutability
- Transparency
- Accountability (via wallet address)

The smart contract uses a hash of the Aadhar number as a secure mapping key to patient records.

---

## 📦 Logging Table: `record_addition_log`

| Field         | Description                              |
|---------------|------------------------------------------|
| `id`          | Auto-increment ID                        |
| `timestamp`   | Time of record insertion                 |
| `ip_address`  | IP address of hospital system            |
| `hospital_name` | Retrieved from logged-in session        |
| `patient_aadhar` | Aadhar number used in record          |
| `blockchain_tx` | Transaction hash of the blockchain call |
| `status`      | Success/Failure                          |
| `source`      | Browser/device info                      |
| `geolocation` | Country/region (optional, JS-based)      |

---

## 🛠 Setup Instructions

### 🖥️ Requirements

- [Node.js](https://nodejs.org/)
- [XAMPP](https://www.apachefriends.org/)
- [MetaMask](https://metamask.io/)
- Git

### 🚀 Run Locally

```bash
git clone https://github.com/your-username/blockchain-medical-records
cd blockchain-medical-records
cd blockchain
npm install
npx hardhat compile
npx hardhat node  # In a separate terminal
npx hardhat run scripts/deploy.js --network localhost
```

Then:

- Import Hardhat local accounts into MetaMask
- Chain ID: 31337
- RPC: http://127.0.0.1:8545
- Open http://localhost/project/login.html in browser

---

## 🔐 Security Approach

- ✅ Blockchain ensures tamper-proof record history
- ✅ Only logged-in hospitals can insert records
- ✅ Proof log stores who/when/why for forensic analysis
- ⚠️ No real Aadhar or patient data used – everything is test data

---

## 📸 Screenshots

### MetaMask transaction confirmation
![MetaMask transaction confirmation](https://github.com/user-attachments/assets/8b7d2f44-0303-4980-91ec-30254d0619bb)

### Login Page
![Login Page](https://github.com/user-attachments/assets/2e0fd2b3-c1e6-41ec-aed5-db66d634b1d4)

### Patient Dashboard
![Patient Dashboard](https://github.com/user-attachments/assets/ce4b19e2-506a-47ee-8756-5a97febf8e40)

### Hospital Dashboard
![Hospital Dashboard](https://github.com/user-attachments/assets/5603227b-f15f-4365-925a-859bf5fe9a9d)

---

## 💡 Future Scope

- 🔐 Real Digilocker or ABHA integration
- 💵 Layer-2 scaling to reduce gas fees (e.g., Polygon)
- 📲 Mobile version with QR-based verification
- 🧾 Patient consent tracking on-chain

---

## 🧑‍💻 Author

Rahul Rao M  
🎓 MCA | Jain University | ISMS Specialization  
🔗 [LinkedIn]([url](https://www.linkedin.com/in/rahul-rao-m/))  

