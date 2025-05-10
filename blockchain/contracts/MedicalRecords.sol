// SPDX-License-Identifier: MIT
pragma solidity ^0.8.21;

contract MedicalRecords {
    struct Record {
        string treatment;
        string doctorName;
        uint256 date;
    }

    mapping(bytes32 => Record[]) private records;

    function _getPatientKey(string memory _patientAadhar) internal pure returns (bytes32) {
        return keccak256(abi.encodePacked(_patientAadhar));
    }

    function addRecord(
        string memory _patientAadhar,
        string memory _treatment,
        string memory _doctorName
    ) public {
        bytes32 key = _getPatientKey(_patientAadhar);

        Record memory newRecord = Record({
            treatment: _treatment,
            doctorName: _doctorName,
            date: block.timestamp
        });

        records[key].push(newRecord);
    }

    function getRecordCount(string memory _patientAadhar) public view returns (uint256) {
        bytes32 key = _getPatientKey(_patientAadhar);
        return records[key].length;
    }

    function getRecordByIndex(string memory _patientAadhar, uint256 index)
        public
        view
        returns (string memory, string memory, uint256)
    {
        bytes32 key = _getPatientKey(_patientAadhar);
        require(index < records[key].length, "Index out of bounds");
        Record memory r = records[key][index];
        return (r.treatment, r.doctorName, r.date);
    }
}
