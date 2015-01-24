#!/bin/bash
cd `dirname $0`
cd ../files

base_url="http://p.smx.lt/"
paste_count=`ls | wc -l`

get_last_pastes() {
	ls -lt --time-style=iso | tail -n +2 | head -${1} | sed 's/....$//'
}

echo "total: ${paste_count}"
get_last_pastes 20 | awk '{print "[" $6 " " $7 "] " "'${base_url}'" $8 }'

exit
