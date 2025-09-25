export const ApiEndpoints = 
{ 
    login: "api/login", 
    User: 
        { 
            getAll: "api/utilisateurs",
            getdetail: "api/utilisateur",
            getModules: (userId: number) => `/api/utilisateur/${userId}/modules`,
            add: 'api/utilisateur/register',
            forgotPassword:'api/mdp-oublie',
            verifyPin:'api/check-pin',
            resetPassword:'api/update-password'
   }
 }

 