#Two dot Seven
<pre>
  _____                      _____   
 /__   \__      _____       |___  |     ___  ______________
   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    
</pre>

###REST Interfaces
- Access URLs are prefixed by domain name *domain*:
- Base Access URI: *domain/dev*
- Response Header Lists:
 - 200: OK (All **echo** responses).
 - 250: Repeated Action Not Executed.
 - 251: Operation completed successfully.
 - 261: Bad Request. Operation cannot be completed.
 - 262: Error In User Input.
 - 252: * Already Exists.
 - 253: * Available.
 - 450: Invalid Request.
 - 406: Not Acceptable.
 - 461: Error while Processing the Action.

###API Version 0.1
1. ***domain/dev/echo***
   Returns the _POST, _GET, _COOKIE, _REQUEST being sent to the server.
   Returns 200 OK HTTP Response.
2. ***domain/dev/redundant/[ACTION]***
  Public API
  - *username*
    Check if a particular User is already registered. Cannot be used to correlate between UserName and Email, for security reasons.
    POST:
    - UserName (Required) The UserName against which the check is to be performed.
    Response: 252, 253, 262 or 450.
  - *email*
    Check if a particular EMail is already registered. Cannot be used to correlate between UserName and Email, for security reasons.
    POST:
    - EMail (Required) The EMail against which the check is to be performed.
    Response: 252, 253, 262 or 450.
3. ***domain/dev/account/[ACTION]***
  Public API
  - *add*
    Adds a new User into the Database.
    POST:
    UserName (Required)
    EMail (Required)
    Password (Required)
    ConfPass (Required)
    Response: 251, 261, or 450.
  - *confirmEmail*
    Confirms the Email of a newly added User.
    POST:
    UserName (Required)
    ConfirmationCode (Required)
    Response: 251, 261, or 450.
  - *generateConfirmationCode*
    Generates a new EMail Confirmation Code, if the previous one was expired or lost.
    POST:
    UserName (Required)
    Response: 251, 261, or 450.
4. ***domain/dev/bit/[BIT]/[BitAction]***
  - Also accessible by *domain/dev/plugin/[BIT]/[BitAction]*.
  - This is implemented by the Bit.
  - **BIT** is the ID of the Plugin.
  - **BitAction** is the Optional parameter, handeled by the Plugin's REST.
  - _GET is allowed for caching.
  - CORS is handeled by the Plugin. Unspecified, otherwise.
5. ***domain/dev/direction/[Function]/[Page]***
  > This API requires admin privileges. Authentication is require.
  - Authentication can be in two ways:
    1. Cookies: Logged in Administrators can call the API through Regular AJAX calls.
    2. API Key and ID: (Not implemented in version 0.1).
  - *userToken*
    Adds a new Token to the specified user. Fail safe method.
    POST:
    1. Do:
      1. Add
         - Additional POST:
           1. UserName (Required) The Target User.
           2. Tag (Required) Token to be added.
         - Response: 251, 261, 450.
      2. Remove
         - Additional POST:
           1. UserName (Required) The Target User.
           2. Tag (Required) Token to be removed.
         - Response: 251, 261, 450.
  - *userPasswordOverride*
    Overrides the specified user's Password.
    EMails the Newly set Password to the registered Email and Deauthorizes all the Existing Sessions.
    POST:
    1. UserName (Required) The target User.
    2. NewPassword (Required) The New Password.
    3. ConfNewPassword (Required) Confirm the new password.
    - Response: 251, 261, 450.
  - *userEMailOverride*
    Overrides the specified user's Email.
    EMails the Newly set Email to the old registered Email as well as the new Email. Requires Re-Verification of Email
    POST:
    1. UserName (Required) The target User.
    2. NewEMail (NewEMail) The New Password.
    - Response: 251, 261, 450.
  - *userEmailValidate*
    Admin Override to Validate a particular user's Email ID.
    POST:
    1. UserName (Required) The target User.
    2. Do (Required) Valid Options are:
      1. VERIFY: Verifies the User's Email.
      2. UNVERIFY: (Default) Un-verifies the User's Email.
    - Response: 251, 261, 450.
  - *userProfileValidate*
    Admin Override to Validate a particular user's Profile.
    POST:
    1. UserName (Required) The target User.
    2. Do (Required) Valid Options are:
      1. VERIFY: Verifies the User's Profile.
      2. UNVERIFY: (Default) Un-verifies the User's Profile.
    - Response: 251, 261, 450.
  - *_markup_getUserList*
    Gets the JSON markup of the *domain/twodot7/administration/user* page.
    GET:
    1. Page Number (Required) The pagination location on the Web app.
    - Response: 251, 261, 450.
6. ***domain/dev/broadcast/[function]/[origin]/[origintype]***
  - This pushes a Broadcast in the stream.
  - V 0.1 only supports the Text Based broadcasts, but the Attachment support is on the way.
  - Requires Authentication.
  - *add*
    Adds a broadcast.
    GET:
    - *origin*: Optional. Specify this in URI. This require a SysAdmin privilege to be executed.
      Also specify the originType and an Override in POST (see below).
      example: *domain/dev/broadcast/add/user/prashant Starts a broadcast process for user Prashant.
    - *origintype*: Required, if *Origin* is specified. See *origin* for usage.
    POST:
    - *BroadcastText*: Required. The Broadcast text.
    - *TargetType*: Required. Valid values are "user", "default", "custom".
    - *Target*: Depends on TargetType. In case of "user", specify valid and existing users, deliminated by ampersand.
    - *OverrideUserName*: Enables the "origin" override. Can be used by a Sysadmin only.
    Example:
    - Access URI: *domain/dev/broadcast/add/user*
    - POST: *BroadcastText* - "Hello World!",
      *TargetType* - "user",
      *Target* - "apoorva&ankit&pragya"
    - Adds a Broadcast "Hello World" targeted to user Apoorva, Ankit and Pragya.

### API Version 0.2 Additions

*Todo.*