// SPDX-License-Identifier: MIT

// import "@openzeppelin/contracts/access/Ownable.sol";

pragma solidity ^0.8.0;

contract StoreCertificate{
    uint usercerti_no;
    uint usercerti_id;
    struct Certificate {
        uint256 index;
        uint id;
        string instiname;
        string stuname;
        string stugrades;
        string stucourse;
        uint timestamp;
        
    }

    mapping (address => Certificate[] ) public certificates;
    address public owner;

    constructor(){
        owner = msg.sender;
    }

    event CertificateAdded(address indexed user, string institutionName, string studentName, string grades, string courseName);

    function CreateCertificate ( string memory iname, string memory sname, string memory sgrades, string memory scourse) external{

        Certificate memory newcerti = Certificate({
            index : certificates[msg.sender].length,
            id : block.number,
            instiname : iname,
            stuname : sname,
            stugrades : sgrades,
            stucourse : scourse,
            timestamp : block.timestamp
            
        });

        certificates[msg.sender].push(newcerti);

        usercerti_no = (certificates[msg.sender].length)-1;
        usercerti_id = block.number;

        emit CertificateAdded(msg.sender, iname, sname, sgrades, scourse);

    }

    function getcerti_idno() public view returns(uint){
        return (usercerti_no);
    }

    function Getcerti(address user, uint id) public view returns(Certificate memory){
        return certificates[user][id]; // Here id is the index value of the array
    }
    

}