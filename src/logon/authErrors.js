emb.authErrors = function(alert){
  
  function errorFor(errorCode, tokenLogin){    
    switch(errorCode) {
      case "password.expired":
        alert( emb.messages.errors.passwordExpiredError );
        break;
      case "password.reset":
        alert( emb.messages.errors.passwordResetError );
        break;
      case "user.lockedexp":
      case "user.suspicious":
      case "user.suspend":
      case "user.inactive":
        alert( emb.messages.errors.suspiciousError );
        break;
      case "user.system.inactive":
      case "password.invalid":
      case "user.not.found":   
        if(tokenLogin){
          alert( emb.messages.errors.userWithCCOTokenNotFoundError );
        }else{
          alert( emb.messages.errors.userNotFoundError );
        } 
        break;
      case "user.locked":
        alert( emb.messages.errors.userLockedError );
        break;
      case "otp.invalid":
        alert( emb.messages.errors.otpInvalidError ); 
        break;
      case "otp.error":
        alert( emb.messages.errors.otpFailedError );
        break;
      case "rsa.secondcoderequired":
          alert( emb.messages.errors.userCCOTokenError );
          break;
      default:
        alert( emb.messages.errors.signalServiceError );
        break;
    }
  }
  
  return {
    errorFor: errorFor
  };
};
