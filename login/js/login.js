function handleCredentialResponse(response) {
    document.getElementById("i_credential").value = response.credential;
    document.getElementById("login_form").submit();
  }
  
  function showGoogle() {
      var centro = document.getElementById("sele_centros").value;
  
      google.accounts.id.initialize({
          client_id: "501337473441-9ir62atud8q43j4fo6m63mkegi7673qh.apps.googleusercontent.com",
          callback: handleCredentialResponse
        });
      google.accounts.id.renderButton(
        document.getElementById("google_signin"),
        { theme: "outline", size: "large" }  // customization attributes
      );
      google.accounts.id.prompt(); // also display the One Tap dialog
  }