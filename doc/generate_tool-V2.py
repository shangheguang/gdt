#! /usr/bin/python

import sys
from optparse import OptionParser
import urllib, urllib2
import base64, hashlib

def ConvSign(page, key, method = 'GET'):
  encode_page = urllib.quote_plus(page)
  conv_property = key + '&' + method + '&' + encode_page
  signature = hashlib.md5(conv_property).hexdigest()
  return signature

def SimpleXor(source, key):
  retval = ''
  j = 0
  for ch in source:
    retval = retval + chr(ord(ch)^ord(key[j]))
    j = j + 1 
    j = j % (len(key))
  return retval

def ConvEncrypt(query_string, key):
  retval = base64.encodestring(SimpleXor(query_string, key)).replace('\n', '')
  return retval

def main(cuser, sid, query_string, sign_key, encrypt_key, attachment):
  page = 'http://t.gdt.qq.com/conv/' + cuser + '/' + sid + '/conv?' + query_string
  print 'STEP 1'
  print '========================================'
  print 'query_string: ' + query_string
  print 'page: ' + page
  print ' '

  signature = ConvSign(page, sign_key)
  query_string += '&sign=' + urllib.quote_plus(signature)
  print 'STEP 2'
  print '========================================'
  print 'sign_key: ' + sign_key
  print 'signature: ' + signature
  print 'query_string: ' + query_string
  print ' '

  data = ConvEncrypt(query_string, encrypt_key)
  request = 'http://t.gdt.qq.com/conv/' + cuser + '/' + sid + '/conv?v=' + urllib.quote_plus(data) + '&' + attachment
  print 'STEP 3'
  print '========================================'
  print 'encrypt_key: ' + encrypt_key
  print 'data: ' + data
  print 'attachment: ' + attachment
  print 'request: ' + request
  print ' '

  return request

if __name__ == '__main__':
  options_parser = OptionParser('usage: %prog -c cuser -i sid -s sign_key -e encrypt_key -r query_string')
  options_parser.add_option("-c", "--cuser", dest="cuser")
  options_parser.add_option("-i", "--sid", dest="sid")
  options_parser.add_option("-s", "--signkey", dest="sign_key")
  options_parser.add_option("-e", "--encryptkey", dest="encrypt_key")
  options_parser.add_option("-r", "--querystring", dest="query_string")
  options_parser.add_option("-a", "--attachment", dest="attachment")
  options, args = options_parser.parse_args()
  if options.cuser == None or options.sid == None or options.query_string == None or options.sign_key == None or options.encrypt_key == None:
    sys.exit(-1)
  main(options.cuser, options.sid, options.query_string, options.sign_key, options.encrypt_key, options.attachment)
  sys.exit(0)

  # python generate_tool.py -c 'app' -i '112233' -s 'test_sign_key' -e 'test_encrypt_key' -r 'click_id=abcdefg%262345678&conv_type=MOBILEAPP_ACTIVITE&conv_time=1406187438&client_ip=10.11.12.13&app_type=ANDROID'