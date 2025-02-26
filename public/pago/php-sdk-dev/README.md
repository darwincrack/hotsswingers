# Paylands PHP SKD  
> A PHP client for paylands api  
  
### Environment Variables  
  
Please set the following environment variables:  
- PAYLANDS_PRODUCTION_URL=https://api.paylands.com/v1/  
- PAYLANDS_SANDBOX_URL=https://api.paylands.com/v1/sandbox/  
- PAYLANDS_API_ENV=[The environment: can be SANDBOX or PRODUCTION]  
- PAYLANDS_API_KEY=[your api key]  
- PAYLANDS_API_SIGNATURE=[your api signature]  

**Note**: It's important to add a trailing slash to the URL's of the environment variables.
  
### Create a client  
  
``` php
$config = new ClientSettings(
	getValueFromEnvironment('PAYLANDS_API_KEY'),
	getValueFromEnvironment('PAYLANDS_API_SIGNATURE'),
	new Environment(getValueFromEnvironment('PAYLANDS_API_ENV') ?? "SANDBOX")
); 
 
$this->paylandsClient = new PaylandsClient($config); 
  
### Call a method  

$customerInput = new CreateCustomerRequest('12345678A');  
$this->paylandsClient->createCustomer($customerInput); 
```