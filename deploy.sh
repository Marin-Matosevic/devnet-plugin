#!/usr/bin/env bash

PLUGIN_NAME=${PWD##*/} # Parent directory name
MAIN_DIR=${PWD}
BUILD_DIR="DIST"
PLUGIN_DIR=$BUILD_DIR/plugin

echo "Remove $BUILD_DIR directory"
rm -rf $BUILD_DIR

echo "Create new $BUILD_DIR directory"
mkdir $BUILD_DIR

echo "Copy to $PLUGIN_DIR"
rsync -av --progress --exclude={'node_modules',$BUILD_DIR,'deploy.sh','package-lock.json','package.json','webpack.config.js','.*'} ./ $PLUGIN_DIR

echo "Zip plugin files"
cd $PLUGIN_DIR
zip -r $PLUGIN_NAME.zip ./
mv $PLUGIN_NAME.zip ../

if [ -n "$TRUNK_PATH" ]
then
echo "Copy plugin files to trunk: $TRUNK_PATH"
cd $MAIN_DIR
rsync -av --progress $PLUGIN_DIR/ $TRUNK_PATH
fi

echo "Done!"


# if permission denied hit:
# chmod +x deploy.sh