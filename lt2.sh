#!/bin/sh
rm -f /tmp/c.txt
csrf=$(curl -s -c /tmp/c.txt http://localhost/auth/login | sed -n 's/.*csrf-token.*content="\([^"]*\)".*/\1/p')
echo "CSRF: $csrf"

# ????????
curl -v -s -X POST http://localhost/auth/login \
  -b /tmp/c.txt \
  -c /tmp/c2.txt \
  -d "email=test@znerp.local" \
  -d "password=test123456" \
  -d "_token=$csrf" \
  -o /tmp/login_body.html \
  -w "\n=== HTTP:%{http_code} ===" 2>&1 | tail -20

echo ""
echo "=== Response body (first 500 chars) ==="
head -c 500 /tmp/login_body.html
echo ""
echo "=== Cookies after login ==="
cat /tmp/c2.txt
