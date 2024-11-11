CREATE DATABASE IF NOT EXISTS ctf_db;
USE ctf_db;

CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,  
  username VARCHAR(30) NOT NULL UNIQUE,         
  password_hash VARCHAR(30) NOT NULL, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);

CREATE TABLE IF NOT EXISTS challenges (
  challenge_id INT AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(30) NOT NULL,                  
  description TEXT,                            
  points INT NOT NULL,                         
  flag VARCHAR(21) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS submissions (
  submission_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  challenge_id INT,
  flag_submitted VARCHAR(21),
  is_correct BOOLEAN,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (challenge_id) REFERENCES challenges(challenge_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_scores (
  user_id INT,                                 
  challenge_id INT,                            
  score INT NOT NULL,                          
  completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
  PRIMARY KEY (user_id, challenge_id),         
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,   
  FOREIGN KEY (challenge_id) REFERENCES challenges(challenge_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS challenge_status (
  challenge_id INT,                             
  user_id INT,                                 
  start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  end_time TIMESTAMP,                           
  status VARCHAR(50),                          
  PRIMARY KEY (challenge_id, user_id),          
  FOREIGN KEY (challenge_id) REFERENCES challenges(challenge_id) ON DELETE CASCADE,  
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  
);

CREATE OR REPLACE VIEW leaderboard AS
SELECT u.username, SUM(s.score) AS total_score
FROM user_scores s
JOIN users u ON s.user_id = u.user_id
GROUP BY u.username
ORDER BY total_score DESC;


-- INSERT INTO challenges (name, description, points, flag) VALUES ('Easy Puzzle', 'Solve this simple puzzle to warm up.', 10, 'CTF{easy_puzzle}');
-- INSERT INTO challenges (name, description, points, flag) VALUES ('Medium Maze', 'Find your way out of this tricky maze.', 50, 'CTF{medium_maze}');
-- INSERT INTO challenges (name, description, points, flag) VALUES ('Hard Cryptography', 'Decrypt the secret message using advanced cryptography.', 100, 'CTF{hard_crypto}');
-- INSERT INTO challenges (name, description, points, flag) VALUES ('SQL Injection Challenge', 'Identify and exploit the SQL vulnerability.', 75, 'CTF{sql_injection}');
-- INSERT INTO challenges (name, description, points, flag) VALUES ('Reverse Engineering', 'Analyze the binary and figure out how it works.', 150, 'CTF{reverse_engineering}');

