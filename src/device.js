emb.device = function() {
  
  function getUserAgent() {
    return navigator.userAgent;
  }

  return {
    getUserAgent: getUserAgent
  };
};