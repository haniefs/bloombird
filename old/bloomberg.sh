curl -X POST 'https://http-api.openbloomberg.com/request?ns=blp&service=refdata&type=HistoricalDataRequest' \
    --cacert bloomberg.crt \
    --cert   client.crt    \
    --key    client.key    \
    --data @- << $1
