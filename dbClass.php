<?php

	class DBLink {

		private $host;
		private $user;
		private $password;
		private $database;
		private $table;
		private $result;

		public $myslqi;

		function __construct() {

			$this->connect();
		}

		private function connect() {
			$this->host = 'localhost';
			$this->user = 'root';
			$this->password = 'wkdcksghks';
			$this->database = 'project';

			$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

			if($this->mysqli->connect_errno) {

				echo "<p>Unable to connect to the database server</p>" .
					 "<p>Error code[{$conn->connect_errno}] : " .
					 "{$conn->connect_error}</p>";
				exit();
			}
		}

		function __destruct() {

			$this->mysqli->close();
		}

		public function call($num) {
			
			echo "call test[$num].";
		}
		
		public function select($name) {

			$sql = "SHOW TABLES LIKE '$name';";

			$this->result = $this->mysqli->query($sql);
			$table = $this->result->num_rows;

			return $table;

		}

		public function create($name) {
			
			echo "<span id='err'>Table doesn't exist.</span><br/>";
			$sql = "CREATE TABLE $name ("
					. "no INT NOT NULL AUTO_INCREMENT, "
					. "id INT(3) NOT NULL DEFAULT 0, "
					. "task VARCHAR(30) NOT NULL, "
					. "created TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "
					. "modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "
					. "status CHAR(1) NOT NULL DEFAULT 'x', "
					. "deleted CHAR(1) NOT NULL DEFAULT 'x', "
					. "PRIMARY KEY(no) "
					. ");";

			if($this->mysqli->query($sql))
				printf("<span id='sys'>Table is created.</span><br/>");
			else
				printf("<span id='err'>Error occurs while creating 'todolist' Table.</span><br/>");
		}

		public function display($table, $username) {

			if(strcmp('admin', $username) == 0) {
				$sql = "SELECT * FROM $table WHERE deleted = 'x';";
			}
			else if(isset($username)) {

				$sql = "SELECT id FROM todouser WHERE username = '$username'";

				$result = $this->mysqli->query($sql);

				while($row = $result->fetch_assoc())
					$id = $row['id'];

				$sql = "SELECT * FROM $table WHERE id = $id AND deleted = 'x';";
			}
			else
				$sql = "SELECT * FROM $table WHERE id = 0 AND deleted = 'x';";

			$result = $this->mysqli->query($sql);

			if(strcmp('admin', $username) == 0) {

				echo "<tr>";
				echo "<th class='user'>User</th>";
				echo "<th class='task'>Task</th>";
				echo "<th class='status'>Status</th>";
				echo "<th class='delete'>Tools</th>";
				echo "</tr>";

				while(($row = $result->fetch_assoc()) != false) {

					$id = $row['id'];
					$no = $row["no"];
					$task = $row["task"];
					$status = $row["status"];
					echo "<tr>";
					echo "<td class='user'>$id</td>";
					echo "<td class='task' ";
						if($status == 'o')
							echo 'style="color: gray; text-decoration: line-through;"';
						echo '>' . $task . "</td>";
					echo "<td class='status'>"
						 . "<input type='checkbox' name='stat'";
						 if($status == 'o')
						 	echo 'checked';
						 echo " onclick='location.href=\"change.php?no=$no\"' /></td>";
					echo "<td class='tools'>
							<a href='detail.php?no=$no'>Detail</a>
							<a href='delete.php?no=$no'>Delete</a>
						  </td>";
					echo "</tr>";
				}

			}
			else {

				echo "<tr>";
				echo "<th class='task'>Task</th>";
				echo "<th class='status'>Status</th>";
				echo "<th class='delete'>Tools</th>";
				echo "</tr>";

				while(($row = $result->fetch_assoc()) != false) {

					$no = $row["no"];
					$task = $row["task"];
					$status = $row["status"];
					echo "<tr>";
					echo "<td class='task' ";
						if($status == 'o')
							echo 'style="color: gray; text-decoration: line-through;"';
						echo '>' . $task . "</td>";
					echo "<td class='status'>"
						 . "<input type='checkbox' name='stat'";
						 if($status == 'o')
						 	echo 'checked';
						 echo " onclick='location.href=\"change.php?no=$no\"' /></td>";
					echo "<td class='tools'>
							<a href='detail.php?no=$no'>Detail</a>
							<a href='delete.php?no=$no'>Delete</a>
						  </td>";
					echo "</tr>";
				}
			}
		}

		public function detail($table, $no) {

			$sql = "SELECT * FROM $table WHERE no = $no;";

			$result = $this->mysqli->query($sql);

			echo "<tr>";
			echo "<th class='task'>Task</th>";
			echo "<th class='created'>Created</th>";
			echo "<th class='modified'>Last Modified</th>";
			echo "<th class='status'>Status</th>";
			echo "</tr>";

			while(($row = $result->fetch_assoc()) != false) {

				$task = $row['task'];
				$created = $row['created'];
				$modified = $row['modified'];
				$status = $row['status'];
		
				echo "<tr>";
				echo "<td>$task</td>";
				echo "<td>$created</td>";
				echo "<td>$modified</td>";
				echo "<td>";
					if($status == 'x') echo "Not Completed";
					else echo "Completed";
				echo"</td>";
				echo "</tr>";
			}

		}

		public function removedItem($table, $no) {

			$sql = "SELECT * FROM $table WHERE no = $no, deleted = 'o';";

			$result = $this->mysqli->query($sql);

			echo "<tr>";
			echo "<th class='task'>Task</th>";
			echo "<th class='created'>Created</th>";
			echo "<th class='modified'>Last Modified</th>";
			echo "<th class='status'>Status</th>";
			echo "</tr>";

			while(($row = $result->fetch_assoc()) != false) {

				$task = $row['task'];
				$created = $row['created'];
				$modified = $row['modified'];
				$status = $row['status'];
		
				echo "<tr>";
				echo "<td>$task</td>";
				echo "<td>$created</td>";
				echo "<td>$modified</td>";
				echo "<td>";
					if($status == 'x') echo "Not Completed";
					else echo "Completed";
				echo"</td>";
				echo "</tr>";
			}

		}
		public function add($table, $task, $username) {

			if(isset($username)) {

				$sql = "SELECT id FROM todouser WHERE username = '$username';";

				$result = $this->mysqli->query($sql);

				while($row = $result->fetch_assoc())
					$id = $row['id'];

				$sql = "INSERT INTO $table (id, task, created, modified) VALUES ($id, '$task', NOW(), NOW());";
			}
			else
				$sql = "INSERT INTO $table (task, created, modified) VALUES ('$task', NOW(), NOW());";

			$result = $this->mysqli->query($sql);

			return $result;
		}

		public function change($no) {

			$sql = "SELECT status FROM todolist WHERE no = $no;";

			$this->result = $this->mysqli->query($sql);
			$result = $this->result->fetch_assoc();

			if($result['status'] == 'x')
				$sql = "UPDATE todolist SET status = 'o', modified = NOW() WHERE no = $no;";
			else if($result['status'] == 'o')
				$sql = "UPDATE todolist SET status = 'x', modified = NOW() WHERE no = $no;";
			else
				echo 'error1';

			$result = $this->mysqli->query($sql);

		}

		public function delete($no) {

			//$sql = "DELETE FROM todolist WHERE no = $no;";

			$sql = "UPDATE todolist SET deleted = 'o', modified = NOW() WHERE no = $no;";

			$result = $this->mysqli->query($sql);

			return $result;
		}

		public function signin($table, $username, $password) {

			$encryptPw = crypt("$password+$username", 'ad%a92PbSf74aBwYi&sJ25FbYnW');

			$sql = "SELECT * FROM $table WHERE username = '$username'";

			$this->result = $this->mysqli->query($sql);
			$result = $this->result->fetch_assoc();

			if(strcmp($encryptPw, $result['password']) == 0) {

				$_SESSION['is_login'] = true;
				$_SESSION['username'] = $username;

				header("location: index.php");
			}
			else
				echo "fail match";
		}

		public function check($password, $checking) {

			$result = false;

			if(strcmp($password, $checking) == 0) {
				$result = true;
			}

			return $result;
		}

		public function register($table, $username, $password, $email) {
			
			$encryptPw = crypt("$password+$username", 'ad%a92PbSf74aBwYi&sJ25FbYnW');

			$sql = "INSERT INTO $table (username, password, email) VALUES ('$username', '$encryptPw', '$email');";

			$result = $this->mysqli->query($sql);

			if($result) {

				$_SESSION['is_login'] = true;
				$_SESSION['username'] = $username;

				header("location: index.php");
			}
		}

		private function hash_equals($str1, $str2) {


		}

	}

?>