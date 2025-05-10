const hre = require("hardhat");

async function main() {
  const contractAddress = "0x5FbDB2315678afecb367f032d93F642f64180aa3";

  const MedicalRecords = await hre.ethers.getContractAt("MedicalRecords", contractAddress);

  // Add a record
  const tx = await MedicalRecords.addRecord("123456789012", "Fever", "Dr. Rahul");
  await tx.wait();
  console.log("✅ Record added");

  // Get count
  const count = await MedicalRecords.getRecordCount("123456789012");
  console.log(`🧾 Total records for Aadhar: ${count}`);

  // Get details of first record
  const record = await MedicalRecords.getRecordByIndex("123456789012", 0);
  console.log("📄 First Record:", {
    treatment: record[0],
    doctor: record[1],
    date: new Date(Number(record[2]) * 1000).toLocaleString()
});
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
