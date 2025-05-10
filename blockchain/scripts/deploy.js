const hre = require("hardhat");

async function main() {
  const MedicalRecords = await hre.ethers.getContractFactory("MedicalRecords");
  const contract = await MedicalRecords.deploy();

  await contract.waitForDeployment(); // ✅ NEW way in recent versions

  const address = await contract.getAddress();
  console.log(`✅ MedicalRecords deployed to: ${address}`);
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
