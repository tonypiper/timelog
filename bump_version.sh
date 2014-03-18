#!/bin/bash

set -e

if [ $# -ne 1 ]; then
  echo "Usage: `basename $0` <tag>"
  exit 65
fi

TAG=$1

#
# Tag & build master branch
#
git checkout master
git tag ${TAG}
box build

#
# Copy executable file into GH pages
#
git checkout gh-pages

cp timelog.phar downloads/timelog-${TAG}.phar
git add downloads/timelog-${TAG}.phar

SHA1=$(openssl sha1 timelog.phar)

JSON='name:"timelog.phar"'
JSON="${JSON},sha1:\"${SHA1}\""
JSON="${JSON},url:\"http://tonypiper.github.io/timelog/downloads/timelog-${TAG}.phar\""
JSON="${JSON},version:\"${TAG}\""

if [ -f timelog.phar.pubkey ]; then
    cp timelog.phar.pubkey pubkeys/timelog-${TAG}.phar.pubkeys
    git add pubkeys/timelog-${TAG}.phar.pubkeys
    JSON="${JSON},publicKey:\"http://tonypiper.github.io/timelog/pubkeys/timelog-${TAG}.phar.pubkey\""
fi

#
# Update manifest
#
cat manifest.json | jsawk -a "this.push({${JSON}})" | python -mjson.tool > manifest.json.tmp
mv manifest.json.tmp manifest.json
git add manifest.json

git commit -m "Bump version ${TAG}"

#
# Go back to master
#
git checkout master

echo "New version created. Now you should run:"
echo "git push origin gh-pages"
echo "git push ${TAG}"