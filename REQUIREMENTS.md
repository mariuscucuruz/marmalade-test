Technical Test - Development Task

If you are reasonably familiar with Symfony, this task should take approximately 3 hours (but don't worry if it takes more or less time than that).

Create a Symfony project (either Symfony 4 or 5) for an API endpoint using DRY and SOLID object-oriented PHP, following PSR-12. The endpoint should accept a JSON payload containing the following fields: age, postcode, regNo. For example, the body of the request might look like this:
 
{
    "age": 20,
    "postcode": "PE3 8AF",
    "regNo": "PJ63 LXR"
}

Your code should make a call to a third party API to look up the vehicle registration number and return an ABI code. Note this does not need to be a real API call - you can mock the response, but still show an example of how you could go about connecting to a third party API.

Use the attached quotation.sql to create a MySQL database which contains rating factors for various ages, postcode areas, and vehicle ABI codes. When a request hits your API, it should start with a base premium of £500 (this can be hard-coded), then find the rating factors to apply for age, postcode area, and ABI code (assume a rating factor of 1 if the value is not in the database). Multiply the premium by each rating factor in turn to obtain a total premium and return an appropriate JSON response. 

Please write the code in such a way that the quoting engine could be used with a different set of rating factors - for example, to allow re-use of the quoting engine with a different insurance product that uses additional or different rating factors, without breaking the existing implementation (bear in mind the open/closed principle here).

What we are looking for:

 * SOLID principles observed
 * PSR-12 followed
 * Good separation of concerns (especially between controller and model layers)
 * Rating factors extendable (hint: allow the rating factors to be specified in the dependency injection container)
 * No security vulnerabilities
 * No commented out code except where used to demonstrate a point (eg. for the mock API call)
 * Code should be executable (no mis-typed variable names, missing use statements, etc.)
 * Code should be concise and well laid out - no excessive use of blank lines, unused use statements, etc.

If your solution involves anything that you feel might require further explanation, or if you feel that some element of best practice is not applicable for some reason, please add comments to the code to explain the reason for your decision.

