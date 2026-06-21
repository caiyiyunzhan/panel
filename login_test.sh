#!/bin/sh
rm -f /tmp/cookies.txt
csrf=$(curl -s -c /tmp/cookies.txt http://localhost/auth/login 2>/dev/null | sed -n "s/.*csrf-token.*content=.\([^\"]*\).*/\1/p")
echo "CSRF: $csrf"
curl -s -w "\nHTTP:%{http_code} LOC:%{redirect_url}\n" -o /dev/null -X POST http://localhost/auth/login -b /tmp/cookies.txt -d "email=admin@znerp.local" -d "password=admin123456" -d "_token=$csrf" 2>&1 
