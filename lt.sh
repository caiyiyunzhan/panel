#!/bin/sh
rm -f /tmp/c.txt
csrf=$(curl -s -c /tmp/c.txt http://localhost/auth/login | sed -n 's/.*csrf-token.*content="\([^"]*\)".*/\1/p')
echo "CSRF: $csrf"
curl -s -w "\nHTTP:%{http_code} LOC:%{redirect_url}\n" -o /dev/null -X POST http://localhost/auth/login -b /tmp/c.txt -d "email=admin@znerp.local" -d "password=admin123456" -d "_token=$csrf"
