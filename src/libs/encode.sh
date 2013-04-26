#!/bin/bash

# --- CONFIG SECTION ---

# Source Dir's params

SDIR="./"    # with slash '/' in the end
SCP="CP1251"        # codepage for 'iconv'
EXT=".*\.(htm[l]*|php[3]*|js|css|tmp|ini|txt|tpl)$"    #files extensions for coding
FCS="windows-1251"    # charset for replace

# Destination Dir's params

DROP_STRUCT=true    # false, true

DDIR="../mzz.new/"    # with slash '/' in the end
DCP="UTF8"        # codepage for 'iconv'
TCS="UTF-8"        # new charset

# --- END CONFIG SECTION ---

# Drop structure
#
if $DROP_STRUCT
then
    rm -dfr $DDIR*
    fi
    
    # Make new copy
    #
    cp -aR $SDIR* $DDIR
    
    # Flush miscoded files
    #
    find $DDIR -type f | grep -E "$EXT" | xargs -i rm -f {}
    
    # Convert From To
    #
    find $SDIR -type f | grep -E "$EXT" | sed "s#$SDIR##" | xargs -i echo {} | \
    while read f
    do
        iconv -c -f $SCP -t $DCP -o "$DDIR$f" "$SDIR$f"
	
	    # Revert MODE & OWNER
	        chmod `find "$SDIR$f" -maxdepth 0 -printf "%m"` "$DDIR$f"
		    chown `find "$SDIR$f" -maxdepth 0 -printf "%u:%g"` "$DDIR$f"
		    
		        # Replace strings
			    perl -pi -e "s#content\s*\=\s*[\"'].*?charset\s*=\s*$FCS.*?[\"']#content=\"text/html; charset=$TCS\"#g" "$DDIR$f"
			    done