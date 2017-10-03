
# coding: utf-8
# -*- coding: utf-8 -*-
import re
import sys
from bs4 import BeautifulSoup
import requests

def cleanhtml(raw_html):
  cleanr = re.compile('<[^<]+?>')
  cleantext = re.sub(cleanr,'', raw_html)
  return cleantext

#$mystring = system("python crawler_wiki.py https://zh.wikipedia.org/wiki/$urlinput", $retval); //wiki
#$mystring = system("python crawler_wiki.py http://www.twwiki.com/wiki/$urlinput", $retval); //taiwan wiki
wikiPediaUrl = "https://zh.wikipedia.org/wiki/";
taiwanWikiUrl = "http://www.twwiki.com/wiki/";
taiwanWordUrl = "http://www.twword.com/wiki/";


termUrl = sys.argv[1];
wikiPediaUrl += termUrl;
taiwanWikiUrl += termUrl;
taiwanWordUrl += termUrl;

WikiPediaRes = requests.get(wikiPediaUrl);
taiwanWikiRes = requests.get(taiwanWikiUrl);
taiwanWordRes = requests.get(taiwanWordUrl);
#-----------------------------------------wikipedia
WPediaSoup = BeautifulSoup(WikiPediaRes.text,'html5lib');
termContent = WPediaSoup.p.encode('utf-8')
termContent = str(termContent);
termContent = cleanhtml(termContent);
termContent = termContent.strip();
if termContent != "":
	print (termContent+"WP");
else:
#-----------------------------------------Taiwan wiki
	TWikiSoup = BeautifulSoup(taiwanWikiRes.text,'html5lib')
	termContent = TWikiSoup.find_all('p',{'class':'mb10'})

	termContent = str(termContent);

	termContent = cleanhtml(termContent);
	termContent = termContent.replace("[","");
	termContent = termContent.replace("]","");
	termContent = termContent.strip();
	if termContent != "":
		print (termContent+"TW");
	else:
		termContent = TWikiSoup.find_all('div',{'class':'mb15'})
		termContent = str(termContent);
		termContent = cleanhtml(termContent);
		termContent = termContent.replace("\\xa0","");
		termContent = termContent.replace("[","");
		termContent = termContent.replace("]","");
		if termContent !="":
			print(termContent+"TW");
		#else:
#-----------------------------------------Taiwan word
			#print ("to do");
			#TWordSoup = BeautifulSoup(taiwanWordRes.text,'html5lib')

#-----------------------------------------
#print(s);


#f = open('res.txt','a')
#f.write(str)