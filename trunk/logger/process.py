import numpy as np
import scipy as sp
import base64
from operator import itemgetter

# Data
# ['permalink', 'currentview', 'ip', 'referer', 'posttype', 'time', 'viewstate']

f = open("log.txt")

counts = {}

data = []
headers = []
doHeaders =  True

for line in f:
    row = []
    parts = line.split(',')
    for part in parts:
        secs = part.split(':')
        k = secs[0]
        if doHeaders:
            headers.append(k)
        v = base64.b64decode(secs[1])
        row.append(v)
    doHeaders = False
    data.append(row)
        
clean = []
for row in data:
    if 'csail' not in row[0] and 'localhost' not in row[0] and 'marcua' not in row[0] and 'eob' not in row[0] and 'redwater' not in row[0] and 'datapress.local' not in row[0] and '127.0.0.1' not in row[0]:
        clean.append(row)

for row in clean:
    # Take Counts
    for header,col in zip(headers,row):        
        if header not in counts:
            counts[header] = {}
        if col not in counts[header]:
            counts[header][col] = 0
        counts[header][col] = counts[header][col] + 1


# Display counts
print "Counts ========================================"
print "==============================================="
for k,v in counts.items():
    srt = sorted(v.items(), key=itemgetter(1), reverse=True)
    tot = sum([s[1] for s in srt])    
    print "%s (%d unique possibilities, summing to %d)" % (k, len(v), tot)
    if len(srt) > 20:
        print "-----(Top 20)---------------------------------"
        for s in srt:#[0:20]:
            print "%d (%d %%) %s" % (s[1], (float(s[1])/float(tot)), s[0])
    else:
        print "----------------------------------------------"
        for s in srt:
            print "%d (%d %%) %s" % (s[1], (float(s[1])/float(tot)), s[0])
    print
    print


{
    'permalink': 'http://projects.csail.mit.edu/datapress/demosite/?p=43', 
    'currentview': 'inline', 
    'ip': '58.63.94.177',
    'referer': 'http://projects.csail.mit.edu/datapress/demosite/wp-content/plugins/datapress/wp-exhibit-only.php?iframe&exhibitid=8&postid=43&currentview=inline', 
    'posttype': 'post', 
    'time': '1277129466', 
    'viewstate': 'inline'
}
