while true; do
  nc -lk -p 2001 -e "cat /var/www/html/flag.txt"
done