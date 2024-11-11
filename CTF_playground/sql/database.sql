CREATE DATABASE IF NOT EXISTS ctf_db;
USE ctf_db;

CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,  
  username VARCHAR(255) NOT NULL UNIQUE,         
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);

CREATE TABLE IF NOT EXISTS challenges (
  challenge_id INT AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL,                  
  description TEXT,                            
  points INT NOT NULL,                         
  flag VARCHAR(255) NOT NULL UNIQUE,           
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

INSERT INTO challenges (name, description, points) VALUES
('Challenge 1', 'Tìm mật khẩu ẩn trong file zip.', 100),
('Challenge 2', 'Giải mã thông điệp bằng Caesar Cipher (shift 3).', 150),
('Challenge 3', 'Phát hiện lỗ hổng SQL Injection và lấy cờ.', 200),
('Challenge 4', 'Tìm cờ trong một ứng dụng web ẩn.', 250),
('Challenge 5', 'Reverse engineer file thực thi để tìm cờ.', 300);

CREATE TABLE IF NOT EXISTS submissions (
  submission_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  challenge_id INT,
  flag_submitted VARCHAR(255),
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

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE challenges (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    flag VARCHAR(255) NOT NULL
);
