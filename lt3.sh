#!/bin/sh
rm -f /tmp/c1.txt /tmp/c2.txt
csrf=`curl -s -c /tmp/c1.txt http://localhost/auth/login | sed -n 's/.*csrf-token.*content="\([^"]*\)".*/\1/p'`
echo "CSRF: $csrf"
curl -s -w "\nHTTP:%{http_code} LOC:%{redirect_url}" -o /tmp/r.txt -X POST http://localhost/auth/login -b /tmp/c1.txt -c /tmp/c2.txt -d "user=admin@znerp.local" -d "password=admin123456" -d "_token=$csrf"
echo ""
cat /tmp/r.txt | head -c 200
