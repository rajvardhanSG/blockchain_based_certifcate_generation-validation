<!doctype html>
<html>
    <head>
        <title>Select the course</title>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.2.7-rc.0/web3.min.js"></script>
        <style>
            body {
            font-family: Arial, sans-serif;
            /* background-color: #f0f0f0; */
            text-align: center;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color:aquamarine;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            width: 100%;
        }

        h1 {
            color: #333333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
            input[type="text"] {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 16px;
            }
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Welcome to the EliteCoders</h1>

            <button><a href="addcourse/addCourse.html">Add new Course</a></button><br><br>
<!-- Let the issuer connect to the metamask and the smart contract-->
            <button onclick="connectMetamask()">Connect to the METSAMASK</button>
	        <p id="accountArea">Status: Not connected to Metamask </p>

            <button onclick="connectContract()">Connect to the Smart Contract</button> <br>
            <p id="contractArea">Status: Not connected to Contract</p>

<!-- Let the issuer enter the data -->
            <div class="form-group">
                <label for="Course">Select the Course:</label>
                <select name="course" id="courses">
                    <?php
                        //connecting to the database
                        $connection = mysqli_connect(
                            'localhost',
                            'root',
                            '123',
                            'ELITE_CODERS'
                        );
                        $q = "SELECT COURSE_NAME FROM ELITE_CODERS.COURSES WHERE ISSUER_ID = 1001";
                        $query = mysqli_query($connection, $q);
                        while($result = mysqli_fetch_assoc($query)){
                            echo "<option value=".$result['COURSE_NAME'].">".$result['COURSE_NAME']."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name of the student:</label>
                <input type="text" id="studentName" name="name" required>
            </div>
            <div class="form-group">
                <label for="grade">Grades:</label>
                <input type="text" id="grades" name="grade" required>
            </div>
            <button id="savedata" onclick="changeWord()">Save Data</button>
        
<!-- create the form to send to the backend -->
            <form action="../backend/certificateGeneration.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="send_instiname" name="send_instiname" value="Issuer1"><br>
                <input type="hidden" id="send_stuname" name="send_stuname"><br>
                <input type="hidden" id="send_grade" name="send_grade"><br>
                <input type="hidden" id="send_course" name="send_course"><br>
                <input type="hidden" id="send_id" name="send_id"><br>
                <button type="submit" id="create" name="submit">Create Certificate</button><br>
            <form>
        
        </div>

<!-- writing the scripts -->
<script>
        let account;
        const connectMetamask = async () => {
            if(window.ethereum !== "undefined"){
                const accounts = await ethereum.request({method: "eth_requestAccounts"});
                account = accounts[0];
                document.getElementById("accountArea").innerHTML = `Account is: ${account}`;
            }

        }

        const connectContract = async () => {
            const ABI = [
                {
                    "inputs": [],
                    "stateMutability": "nonpayable",
                    "type": "constructor"
                },
                {
                    "anonymous": false,
                    "inputs": [
                        {
                            "indexed": true,
                            "internalType": "address",
                            "name": "user",
                            "type": "address"
                        },
                        {
                            "indexed": false,
                            "internalType": "string",
                            "name": "institutionName",
                            "type": "string"
                        },
                        {
                            "indexed": false,
                            "internalType": "string",
                            "name": "studentName",
                            "type": "string"
                        },
                        {
                            "indexed": false,
                            "internalType": "string",
                            "name": "grades",
                            "type": "string"
                        },
                        {
                            "indexed": false,
                            "internalType": "string",
                            "name": "courseName",
                            "type": "string"
                        }
                    ],
                    "name": "CertificateAdded",
                    "type": "event"
                },
                {
                    "inputs": [
                        {
                            "internalType": "string",
                            "name": "iname",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "sname",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "sgrades",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "scourse",
                            "type": "string"
                        }
                    ],
                    "name": "CreateCertificate",
                    "outputs": [],
                    "stateMutability": "nonpayable",
                    "type": "function"
                },
                {
                    "inputs": [
                        {
                            "internalType": "address",
                            "name": "",
                            "type": "address"
                        },
                        {
                            "internalType": "uint256",
                            "name": "",
                            "type": "uint256"
                        }
                    ],
                    "name": "certificates",
                    "outputs": [
                        {
                            "internalType": "uint256",
                            "name": "index",
                            "type": "uint256"
                        },
                        {
                            "internalType": "uint256",
                            "name": "id",
                            "type": "uint256"
                        },
                        {
                            "internalType": "string",
                            "name": "instiname",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "stuname",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "stugrades",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "stucourse",
                            "type": "string"
                        },
                        {
                            "internalType": "uint256",
                            "name": "timestamp",
                            "type": "uint256"
                        }
                    ],
                    "stateMutability": "view",
                    "type": "function"
                },
                {
                    "inputs": [
                        {
                            "internalType": "address",
                            "name": "user",
                            "type": "address"
                        },
                        {
                            "internalType": "uint256",
                            "name": "id",
                            "type": "uint256"
                        }
                    ],
                    "name": "Getcerti",
                    "outputs": [
                        {
                            "components": [
                                {
                                    "internalType": "uint256",
                                    "name": "index",
                                    "type": "uint256"
                                },
                                {
                                    "internalType": "uint256",
                                    "name": "id",
                                    "type": "uint256"
                                },
                                {
                                    "internalType": "string",
                                    "name": "instiname",
                                    "type": "string"
                                },
                                {
                                    "internalType": "string",
                                    "name": "stuname",
                                    "type": "string"
                                },
                                {
                                    "internalType": "string",
                                    "name": "stugrades",
                                    "type": "string"
                                },
                                {
                                    "internalType": "string",
                                    "name": "stucourse",
                                    "type": "string"
                                },
                                {
                                    "internalType": "uint256",
                                    "name": "timestamp",
                                    "type": "uint256"
                                }
                            ],
                            "internalType": "struct StoreCertificate.Certificate",
                            "name": "",
                            "type": "tuple"
                        }
                    ],
                    "stateMutability": "view",
                    "type": "function"
                },
                {
                    "inputs": [],
                    "name": "getcerti_idno",
                    "outputs": [
                        {
                            "internalType": "uint256",
                            "name": "",
                            "type": "uint256"
                        }
                    ],
                    "stateMutability": "view",
                    "type": "function"
                },
                {
                    "inputs": [],
                    "name": "owner",
                    "outputs": [
                        {
                            "internalType": "address",
                            "name": "",
                            "type": "address"
                        }
                    ],
                    "stateMutability": "view",
                    "type": "function"
                }
            ];
            const Address = "0x0db6B7431e525D835B64474A14ae4DeBeC6C7f4B";
            window.web3 = await new Web3(window.ethereum);
            window.contract = await new window.web3.eth.Contract(ABI, Address);
            document.getElementById("contractArea").innerHTML = "Connection Status: Success";
        }

        const changeWord = async () => {
            // const myEntry = document.getElementById("inputArea").value;
            const institution = "Issuer1";
            const stuName = document.getElementById("studentName").value;
            const stuGrades = document.getElementById("grades").value;
            const stuCourse = document.getElementById("courses").value;

            await window.contract.methods.CreateCertificate(institution, stuName, stuGrades, stuCourse).send({ from: account });
            const certi_id = await window.contract.methods.getcerti_idno().call()
            if(certi_id!=null){
                // document.getElementById("send_instiname").setAttribute('value', institution);
                document.getElementById("send_stuname").setAttribute('value', stuName);
                document.getElementById("send_grade").setAttribute('value', stuGrades);
                document.getElementById("send_course").setAttribute('value', stuCourse);
                document.getElementById("send_id").setAttribute('value', certi_id);
            }
        }
    </script>
    </body>
</html>


<!--         
 -->