import requests, json

powerschool_url = "http://powerschool-ag.dev.sifworks.com/oauth/access_token/"
data = "grant_type=client_credentials" 
r = requests.post(powerschool_url, data, auth=('b5fe6dcb-e825-4e52-be5c-5ce283459f49', 'd6e0f091-e6cc-4b21-8c9b-7464470b1663'))

print r.json