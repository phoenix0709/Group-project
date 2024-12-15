#!/bin/bash

RANDOM=$(head /dev/urandom | tr -dc A-Za-z0-9 | head -c 8)
FLAG="CTF{multi_stage_bypass_${RANDOM}}"

mysql -h "db" -u "user" -p"userpassword" "ctf_db" <<EOF
INSERT INTO challenges (id, flag) VALUES (5, '$FLAG')
ON DUPLICATE KEY UPDATE flag='$FLAG';
EOF
