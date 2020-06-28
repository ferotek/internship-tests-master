<?php

class Thread
{
    /**
     * @var mixed
     */
    private $db;

    /**
     * Thread constructor.
     *
     */
	 


	 
	 //Adds support for using a database
	 /*
	 created functions to create a database, create a table, and insert data to the created table
	 */
	 
	 
	public function createTable(){
		
		$servername = 'localhost';
		$username = "root";
		$password = "";
		$dbname = "slickdeals";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		
		
		$sql = 'CREATE TABLE IF NOT EXISTS PostMessage (
		threadid INT(8) NOT NULL, 
		title VARCHAR(32) NOT NULL,
		message VARCHAR(52) NOT NULL,
		message_html VARCHAR(52) NOT NULL,
		timeposted INT(10) NOT NULL,
		PRIMARY KEY(threadid)
		);';
		
		if ($conn->query($sql) === TRUE) {
		echo "\n";
			} else {
		echo "Error creating table: " . $conn->error;
			}
		
	}
	
	public function insertQuery($title, $message, $message_html, $isVisible, $timePosted){
		
		$servername = 'localhost';
		$username = "root";
		$password = "";
		$dbname = "slickdeals";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		
		
		
		$squery = "INSERT INTO `PostMessage` VALUES ('%d', '%s', '%s', '%d', '%d')";
		$sql = sprintf($squery, $title, $message, $message_html, $isVisible, $timePosted);
		
		//echo $sql; 
		
		if ($conn->query($sql) === TRUE) {
		echo "Query Inserted successfully\n";
			} else {
		echo "Error creating table: " . $conn->error;
			}
		

		
	}
	
	
    public function __construct()
    {
		
		$servername = 'localhost';
		$username = "root";
		$password = "";
        // Normally we would do things differently, but we did it this way for simplification
        require_once(__DIR__ . '/DatabaseFile.php');

        $this->db = new DatabaseFile();
		
		//creates table and database
		
		$conn = new mysqli($servername, $username, $password);
		
		$sql = "CREATE DATABASE IF NOT EXISTS slickdeals";
		
		if ($conn->query($sql) === TRUE) {
			echo "Database created successfully";
		} else {
		echo "Error creating database: " . $conn->error;
		}
		
    }

    /**
     * @param string $title
     * @param string $message
     * @param bool   $isVisible
     * @param int    $timePosted
     * @param string    $message_html
     */
    public function newThread($title, $message, $isVisible, $timePosted)
    {
		
		//convert url to html link if there is a url link in the message
		
		if(preg_match('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $message)){
			$string = preg_replace('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', '', $message);

			preg_match('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $message, $result);
			
			$foo = $result[0];
			

			
			

			
			$message_html  = '<a href="'.$foo.'">'.$string.'</a>';
			
			echo $message_html;
			

		}else{

			$message_html = $message;
			
			
		}
		
		

		
        $title = time() - strtotime('2016-11-25');
		
		//inserts data into database

        $this->db->insert('thread', [
            'threadid' => $this->db->primaryKey(),
            'title' => $title,
            'message' => $message,
			'message_html' => $message_html, 
            'visible' => intval($isVisible),
            'timeposted' => $timePosted,
        ]);
		
		$this -> createTable();
		
		
		$this -> insertQuery($title, $message, $message_html, $isVisible, $timePosted);
		
		
    }

    /**
     * @param int  $numThreads
     * @param bool $includeHidden
     *
     * @return array
     */
    public function getRecentThreads($numThreads, $includeHidden)
    {
        $columns = [
            'threadid',
            'title',
            'message',
            'message_html',
            'timeposted',
        ];

        $conditions = ($includeHidden)
            ? []
            : ['visible' => 1];

        return $this->db->select('thread', $columns, $conditions, 'timeposted', false, $numThreads);
    }
}