#!/bin/bash
for f in `find . -name "*.JPG"`
do
    convert -thumbnail 150 $f $f.thumb
done
