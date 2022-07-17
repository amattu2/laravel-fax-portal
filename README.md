# Introduction

This is a W.I.P. portal to receive incoming faxes from the Twilio API, and forward them to an email.

## To-Do

- [ ] Process incoming faxes and store them
- [ ] Require basic auth for the Twilio API
- [ ] Build a basic listing of faxes enabled only during debug mode

## Notes

- This project is based loosely on the Sendgrid/Twilio tutorial [here](https://www.twilio.com/blog/fax-email-sendgrid-nodejs) because of the lack of documentation for the Twilio fax receive API.
- The TwilML request body documentation is [here](https://www.twilio.com/docs/voice/twiml). It's assumed that Faxes conform to this, at least partially.
- The TwilML SDK Fax Receive information is in this [repository](https://github.com/twilio/twilio-php/blob/main/src/Twilio/TwiML/Fax/Receive.php).

# Requirements & Dependencies

- PHP 8.0+
- Laravel 9.0+
- NPM/Composer
