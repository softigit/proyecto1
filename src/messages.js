emb.messages = emb.messages || {};

emb.messages.errors = {
    signalServiceError: "Temporalmente no podemos contectarnos con M&U. Por favor intente más tarde. Gracias por su paciencia.",
    noLocationsFound: "No Branch locations were found within a 50 mile radius. Please modify your search criteria or try a different address.",
    gpsLocationDenied: "Your geolocation is disabled. Please use the manual search option.",
    gpsLocationUnavailable: "Your position could not be determined. Please use the manual search option.",
    billPayEnrollmentError: "You're currently not enrolled in our Bill Pay service. Please log on to Chase.com from your personal computer to activate this service.",
    creditCardEnrollmentError: "You're currently not enrolled in ePay. Please log on to Chase.com from your personal computer to enroll in this service. If you need to make your payment today, please call the number on the back of your card.",
    quickPayEnrollmentError: "You're not currently enrolled in our QuickPay Service. Please log on to www.chase.com/QuickPay from your personal computer to enroll in this service.",
    quickPayFulfillmentError: "You may need to activate your service. Please log on to www.chase.com/QuickPay to make sure you've verified your email address and set up a valid Pay To account.",
    wiredEnrollmentError: "You're currently not enrolled in our Wire Transfers service. Please log on to Chase.com from your personal computer to activate this service.",
    transferEnrollmentError: "You're currently not enrolled in our Transfers service. Please log on to Chase.com from your personal computer to activate this service.",
    transferNoAccountsError: "You currently don't have any eligible transfer accounts.",
    noSessionError: "For your security, please log in with your User ID and Password.",
    noAlertsDevicesSelected: "Tell us where you'd like the alert sent.",
    hiddenAccountsError: "We're unable to display information about your account(s) on your mobile device. Please log on to Chase.com from your personal computer to see your account details.",
    userLockedError: "You have exceeded the maximum number of logon attempts allowed. Please contact Customer Service to unlock your User ID. \n\n Online and Mobile Support:\n1-877-210-1672, 7 AM-9 PM local time, 7 days/week",
    userNotFoundError: "The User ID or Password you entered is incorrect. Please reenter your User ID and Password.",
    userWithCCOTokenNotFoundError: "The User ID, Password or token code you entered is incorrect. Please re-enter your User ID, Password, and token code to regain access to your account.",
    userCCOTokenError: "Note: For security reasons, please re-enter your User ID, Password, and two sequential token codes.",
    passwordExpiredError: "Your Password has expired. Please log on to Chase.com from your personal computer to reset your Password.",
    passwordResetError: "To access your accounts through your mobile browser, you must first reset your Password on Chase.com from your personal computer.",
    suspiciousError: "Your User ID and Password are inactive. Please call 1-877-242-7372 (outside the U.S.: 1-713-262-3300) to restore your online access.",
    otpFailedError: "To access your accounts through your mobile browser, you must first reset your Password on Chase.com from your personal computer.",
    otpInvalidError: "You've entered an incorrect Identification Code or Password. Please verify the code and your Password and try again.",
    quickPayUnavailable: "We're unable to perform this QuickPay function. Please try again later. Thanks for your patience."
};

emb.messages.warnings = {
  systemTimeout: "Your banking session will expire in approximately one minute.",
  cookiesDisabled: "Your browser seems to have cookies disabled. Please enable them in your browser settings so you can log on to our site and see all of its features."
};

emb.messages.information = {
  noAccountActivities: "There's no activity to display for this account.",
  noPayees: "Please log on to Chase.com from your personal computer to add a payee.",
  noWirePayees: "Please log on to Chase.com from your personal computer to add a recipient.",
  otherAmount: "Amount cannot exceed current balance.",
  requestSubmitted: "Your request has been submitted.",
  offerMessageForNonPhones: "We can't complete this call from your device. Please call <%=phone%> to apply. We're available 24 hours a day.",
  cxcRedirectTitle: "You're Now Leaving Chase",
  cxcRedirectMessage: "Chase is not responsible for, and does not provide or endorse this third-party site's products, services or other content. Chase's privacy notice and security practices do not apply to the site you're about to enter, so please review the third party's privacy and security practices.",
  billPayR2EnrollmentWarning: "We've automatically added all your Chase accounts to the payee list to improve your experience. You can make payments to your Chase Payees at this time. However in order for you to add merchant payees, you must enroll in the Pay Bills service by logging in to Chase.com from your personal computer.",
  billPayR2EligibleAndNoPayees: "You're currently not enrolled in our Pay Bills service. Please log on to Chase.com from your personal computer to activate this service."
};

emb.messages.logonErrors = [
  {
    user: {
      locked: {
        title: "You've exceeded the maximum number of failed log in attempts. Please visit Chase.com from a computer and click “Forgot User ID/Password?” or call 1-877-210-1672 to reset. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        secondaryButton: "Ok"
      },
      fraud: {
        title: "Your access has been suspended. Please call 1-877-611-3062 or if you’re a Chase Credit Card customer, call 1-800-432-3117. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        secondaryButton: "Ok"
      },
      suspicious: {
        title: "Your access has been suspended. Please call 1-877-691-8086 (Option 3) or 1-713-427-6380 (Int’l) to reactivate. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        secondaryButton: "Ok"
      }
    }
  },
  {
    user: {
      locked: {
        title: "Too Many Log In Attempts",
        message: "Please visit Chase.com from a computer and click “Forgot User ID/Password?” or call us to reset. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        number: {
          label: "Call Support",
          digits: "1-877-210-1672"
        },
        secondaryButton: "Cancel"
      },
      fraud: {
        title: "Account Suspended",
        message: "Please call us for more information. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        number: {
          label: "Call Personal Checking & Savings",
          digits: "1-877-611-3062"
        },
        number2: {
          label: "Call Card Services",
          digits: "1-800-432-3117"
        },
        secondaryButton: "Cancel"
      },
      suspicious: {
        title: "Access Suspended",
        message: "Please call us to reactivate. For Commercial, Private Bank, or J.P. Morgan Securities clients, please contact your Service Team.",
        number: {
          label: "Call Support (Option 3)",
          digits: "1-877-691-8086"
        },
        number2: {
          label: "Call Support (International)",
          digits: "1-713-427-6380"
        },
        secondaryButton: "Cancel"
      }
    }
  }
];

_.each(emb.messages.logonErrors, function(elm, index, logonErrors) {
  logonErrors[index].user.lockedexp = logonErrors[index].user.locked;
  logonErrors[index].user.inactive = logonErrors[index].user.fraud;
  logonErrors[index].user.suspend = logonErrors[index].user.fraud;
});
