#!/bin/bash
for f in `find . -name "*[JPG,jpg]"`
do
    convert -thumbnail '150x100' $f $f.thumb
done
