import * as nearAPI from "near-api-js";
import ls from "local-storage";
import Big from "big.js";
import _ from "lodash";
const TGas = Big(10).pow(12);
const BoatOfGas = Big(200).mul(TGas);
const UploadResizeWidth = 96;
const UploadResizeHeight = 96;
const MaxU128 = Big(2).pow(128).sub(1);
const MinAccountIdLen = 2;
const MaxAccountIdLen = 64;
const ValidAccountRe = /^(([a-z\d]+[-_])*[a-z\d]+\.)*([a-z\d]+[-_])*[a-z\d]+$/;
const ValidTokenIdRe = /^[a-z\d]+$/;
//const contractCode = './contract/contract.wasm';
class NearIntegration {
    constructor() {
        // NEAR connection parameters
        
        this.ContractName = "tokens.testnet";
        this.lsKey =  this.ContractName + ":v02:";
        this.lsKeyToken = this.lsKey + "token";
        this.lsKeyCachedTokens = this.lsKey + "cachedTokens";
        this.lsKeyCreateToken = this.lsKey + "createToken";
        this._updateRequiredDeposit = null;

        // const nearConfig = {
        //     networkId: "testnet",
        //     nodeUrl: "https://rpc.testnet.near.org",
        //     walletUrl: "https://wallet.testnet.near.org",
        //     helperUrl: "https://helper.testnet.near.org",
        //     contractName: this.ContractName,
        // };

        this.accountId = null;

        this.connected = false;
        this.signedIn = false;
        this.creating = false;
        this.accountId = null;
        this.tokenLoading = false;
        this.tokenAlreadyExists = false;
        this.readyForWalletWhitelist = false;
        this.expandCreateToken = false;
    
        this.accountLoading = false;
        this.accountExists = true;
    
        this.tokenId = "";
        this.totalSupply = Big("1000000000");
        this.tokenDecimals = 18;
        this.tokenName = "";
        this.tokenIconBase64 = null;
        this.requiredDeposit = null;

        // Initialize NEAR connection
        // this.near = new nearAPI.Near(nearConfig);

        // // Initialize wallet connection
        //this.wallet = new nearAPI.WalletConnection(this.near, 'tokens.testnet');

        // // Initialize contract instance
        // this.contract = new nearAPI.Contract(this.wallet.account(), nearConfig.contractName, {
        //   viewMethods: [
        //     "get_required_deposit",
        //     "get_number_of_tokens",
        //     "get_tokens",
        //     "get_token",
        //   ],
        //  // changeMethods: ['setGreeting'],
        //  changeMethods: ["create_token", "storage_deposit"],
        //   sender: this.wallet.account(),
        // });
        // this._initNear().then(() => {
        //     this.accountId = this._accountId;
        //     console.log(this._ownerId);

        //     if (this._ownerId) {

        //         this.showLoginInfo(this.accountId);
        //         this.createTokenButton();
        //         this.createAccountButton();
        //     } else {
                
        //         this.createButtonLogin();
        //     }
        // });
    }

    // async _initNear() {
    //     const nearConfig = {
    //         networkId: "testnet",
    //         nodeUrl: "https://rpc.testnet.near.org",
    //         contractName: this.ContractName,
    //         walletUrl: "https://wallet.testnet.near.org",
    //     };
    //     const ContractName = this.ContractName;
    //     const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
    //     const near = await nearAPI.connect(Object.assign({ deps: { keyStore } }, nearConfig));
    //     this._keyStore = keyStore;
    //     this._nearConfig = nearConfig;
    //     this._near = near;

    //     this._walletConnection = new nearAPI.WalletConnection(near, ContractName);
    //     this._accountId = this._walletConnection.getAccountId();
    //     this._ownerId = this._accountId;

    //     this._account = this._walletConnection.account();
    //     this._contract = new nearAPI.Contract(this._account, ContractName, {
    //         viewMethods: ["get_required_deposit", "get_number_of_tokens", "get_tokens", "get_token"],
    //         changeMethods: ["create_token", "storage_deposit"],
    //     });
    //     await this._initYourToken();
        
        
    // }

    
    /* ======================================== Function */
    // async _initYourToken() {
    //     const args = ls.get(this.lsKeyToken);
        
       
       
        
    //     if (args) {
    //         const createToken = ls.get(this.lsKeyCreateToken);
    //         if (createToken) {
    //             ls.remove(this.lsKeyCreateToken);
    //             this.creating = true;
    //            // ls.set(this.lsKeyToken, 'cre');
    //             const requiredDeposit = await this.computeRequiredDeposit(args);
    //             if (requiredDeposit.eq(0)) {
    //                 await this._contract.create_token({ args }, BoatOfGas.toFixed(0)).then((result) => {
                        
    //                     console.log('result');
    //                     console.log(result);
                        
    //                   })
    //                   .catch((error) => {
                       
    //                     console.error(error);
                        
    //                   });
                                       
    //             } else {
    //                 this._ownerId = args.owner_id;
    //                 this.tokenId = args.metadata.symbol;
    //                 this.totalSupply = Big(args.total_supply).div(
    //                     Big(10).pow(parseInt(args.metadata.decimals))
    //                 );
    //                 this.tokenDecimals = args.metadata.decimals;
    //                 this.tokenName = args.metadata.name;
    //                 this.tokenIconBase64 = args.metadata.icon;
    //                 // Transaction was canceled.
                    
    //                 console.log('cancel');
    //             }
    //             ls.remove(this.lsKeyToken);
    //             this.creating = false;
    //             // this.setState({
    //             //     creating: false,
    //             //     readyForWalletWhitelist: true,
    //             //     tokenId: args.metadata.symbol,
    //             //     totalSupply: Big(args.total_supply).div(
    //             //         Big(10).pow(args.metadata.decimals)
    //             //     ),
    //             //     tokenDecimals: args.metadata.decimals,
    //             //     tokenName: args.metadata.name,
    //             //     tokenIconBase64: args.metadata.icon,
    //             // });
    //         }
    //     }
    //     this.updateRequiredDeposit();
        
    // }

    async  createSubAccount(ContractName) {
        //         const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
        //   const nearConfig = {
        //     networkId: 'testnet',
        //     nodeUrl: 'https://rpc.testnet.near.org',
        //     keyStore: keyStore,
        //   };
        
        //   const near = await nearAPI.connect(nearConfig);
        //   const keyPair = nearAPI.KeyPair.fromString('ed25519:4v2cDMaeNKVgbGA6cHvN53GSdjiTEGG7pfu6gRpPjJd7MHPwhgqubA2s6zkkjgq9oMyDcugqr3kHMDqf8PEurW81'); // Thay thế bằng khóa bí mật của bạn
        //   const publicKey = keyPair.getPublicKey();
        

        
        //   console.log('Khóa công khai:', publicKey.toString());

    }
    
    // createAccountButton() {
    //     const tokenWrap = document.getElementById("create-account-wrap") || false;
       
    //     const createButton = document.createElement("p");
    //     createButton.textContent = "Create Token";
    //     createButton.id = "createAccountButton";
    //     createButton.className = "btn btn-warning mt-3 btn-rounded";
        
        
    //     const masterAccountId = 'ctoken.testnet';
    //     const subAccountId = 'sub334-account.' + masterAccountId;
        
        
    //     if (tokenWrap) {
    //         tokenWrap.appendChild(createButton);
    //         createButton.addEventListener("click", () => {
    //             this.createSubAccountWithContract(masterAccountId, subAccountId, contractCode);
    //         });
    //     }
        
    // }
    
    // async createSubAccountWithContract(masterAccountId, subAccountId, contractCode) {
    //       try {
    //         const nearConfig = {
    //             networkId: "testnet",
    //             nodeUrl: "https://rpc.testnet.near.org",
    //             walletUrl: "https://wallet.testnet.near.org",
    //         };
    //         const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
    //         const near = await nearAPI.connect(Object.assign({ deps: { keyStore } }, nearConfig));
            
        
    //         const masterPrivateKey = '4v2cDMaeNKVgbGA6cHvN53GSdjiTEGG7pfu6gRpPjJd7MHPwhgqubA2s6zkkjgq9oMyDcugqr3kHMDqf8PEurW81';
    //         const masterAccount = await near.account(masterAccountId);
    //         const keyPair = nearAPI.KeyPair.fromString(masterPrivateKey);
    //         await keyStore.setKey(nearConfig.networkId, masterAccountId, keyPair);
        
    //         const publicKey = '2bpkhkMAgGLDVayy1uNhMf1JudLaBUi4KfyusKE4kwRb';
        
    //         await masterAccount.createAccount(subAccountId, publicKey, '10000000000000000000');
              
    //         const subAccount = await near.account(subAccountId);
    //         const accountExists = await subAccount.state();
    //         if (accountExists) {
    //           console.log(`Done create ${subAccountId}.`);
    //         } 
    //         else {
    //           console.log(`Error create account ${subAccountId}.`);
    //         }
    //         const contractAccount = await near.account(subAccountId);
              
    //         await contractAccount.deployContract((contractCode));
            
        
    //         // console.log(`Smart contract deployed to sub account: ${subAccountId}`);
        
    //         // console.log('Deployment completed successfully!');
    //       } catch (error) {
    //         console.error('Error deploying contract:', error);
    //       }
    // }
    
   

    // async internalUpdateRequiredDeposit() {
    //     if (this._accountId) {
    //       const requiredDeposit = await this.computeRequiredDeposit();
          
    //     }
    // }
    
    // updateRequiredDeposit() {
    //     if (this._updateRequiredDeposit) {
    //       clearTimeout(this._updateRequiredDeposit);
    //       this._updateRequiredDeposit = null;
    //     }
    //     this._updateRequiredDeposit = setTimeout(
    //       () => this.internalUpdateRequiredDeposit(),
    //       250
    //     );
    // }

    // constructArgs() {
    //     return {
    //       owner_id: this._accountId,
    //       total_supply: Big(this.totalSupply)
    //         .mul(Big(10).pow(parseInt(this.tokenDecimals)))
    //         .round(0, 0)
    //         .toFixed(0),
    //       metadata: {
    //         spec: "ft-1.0.0",
    //         name: this.tokenName,
    //         symbol: this.tokenId,
    //         icon: this.tokenIconBase64,
    //         decimals: this.tokenDecimals,
    //       },
    //     };
    // }

    // showSnackbar(text) {
    //     const snackbar = document.createElement('div');
    //     snackbar.className = 'show';
    //     snackbar.id = 'snackbar';
    //     snackbar.textContent = text;
    
    //     document.body.appendChild(snackbar);
    //     // Add animation class to show the snackbar
    //     snackbar.classList.add('show');

    //     setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);

    // }

    
    
    
    // async createToken() {
       
    //     this.tokenName = this.getInputValue('token_name');
    //     this.totalSupply = this.getInputValue('total_supply');
    //     this.tokenDecimals = parseInt(this.getInputValue('token_decimals'));
    //     this.tokenIconBase64 = this.getInputValue('b64');
        
    //     this.tokenId = this.getInputValue('token_symbol');

    //     const args = this.constructArgs();
        
        
    //     const requiredDeposit = await this.computeRequiredDeposit(args);
        
    //     //
    //     const tokenSym = this.tokenId.replace(/[^a-zA-Z\d]/, "");
    //     const tokenId  = tokenSym.toLowerCase();
        

    //     if (this.isValidTokenId(tokenSym)) {
    //         this._contract
    //           .get_token({ token_id: tokenId })
    //           .then(async (tokenDescription) => {
               
    //             if (tokenDescription !== null) {
    //                 this.showSnackbar('Token exist');
    //                 this.tokenAlreadyExists = true;
    //             }
    //             else {
              
    //                 ls.set(this.lsKeyToken, args);
    //                 ls.set(this.lsKeyCreateToken, true);
                 
    //                 await this._contract.storage_deposit(
    //                   {},
    //                   BoatOfGas.toFixed(0),
    //                   requiredDeposit.toFixed(0)
    //                 );
    //             }
    //           })
    //           .catch((e) => {
    //             this.showSnackbar('Error check token call');
    //           });
    //     }

        
    // }
    // async logOut() {
    //     this._walletConnection.signOut();
    //     this._accountId = null;
    //     this.accountId = null;
    //     this.clearElement("logoutContainer");
    //     this.createButtonLogin();
    // }

    // isValidAccountId(accountId) {
    //     return (
    //         accountId.length >= MinAccountIdLen &&
    //         accountId.length <= MaxAccountIdLen &&
    //         accountId.match(ValidAccountRe)
    //     );
    // }
    
    // isValidTokenId(tokenId) {
    //     tokenId = tokenId.toLowerCase();
    //     return (
    //       tokenId.match(ValidTokenIdRe) &&
    //       this.isValidAccountId(tokenId + "." + this.ContractName)
    //     );
    // }


    // async computeRequiredDeposit(args) {
    //     args = args || this.constructArgs();
    //     return Big(
    //       await this._contract.get_required_deposit({
    //         args,
    //         account_id: this._accountId,
    //       })
    //     );
    // }

    // async connectToWallet() {
    //     const appTitle = "Token Factory";
    //     await this._walletConnection.requestSignIn(this.ContractName, appTitle);
    // }
    
    

    /* ======================================== End Function */

    // getInputValue(inputId) {
    //     // Get the input element by ID
    //     var inputElement = document.getElementById(inputId);
    //     // Retrieve the value of the input element
    //     var value = inputElement.value;
    //     return value;
    // }
    // removeElement(ele) {
    //     const element = document.getElementById(ele);
    //     element.remove();
    // }
    // createButtonLogin() {
    //     const loginInfo = document.getElementById("loginWrap");
       
    //     const loginButton = document.createElement("button");
    //     loginButton.textContent = "Connect NEAR Wallet";
    //     loginButton.id = "connectButton";
    //     loginButton.className = "btn btn-primary";

    //    // const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
    //     loginInfo.appendChild(loginButton);
    //     loginButton.addEventListener("click", () => {
    //         this.connectToWallet();
    //     });
    // }
    
    // createTokenButton() {
    //     const tokenWrap = document.getElementById("create-token-wrap") || false;
       
    //     const createButton = document.createElement("p");
    //     createButton.textContent = "Create Token";
    //     createButton.id = "createTokenButton";
    //     createButton.className = "btn btn-warning mt-3 btn-rounded";

    //     // const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
    //     if (tokenWrap) {
    //         tokenWrap.appendChild(createButton);
    //         createButton.addEventListener("click", () => {
    //             this.createToken();
    //         });
    //     }
        
    // }
    
    

    // clearElement(elementID){
    //     document.getElementById(elementID).innerHTML = "";
    // }
   

    // showLoginInfo(accountId) {
    //     const logoutButton = document.createElement("button");
    //     logoutButton.textContent = "Logout";
    //     logoutButton.id = "logoutButton";

    //     logoutButton.className = "btn btn-danger";

    //     const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
    //     container.appendChild(logoutButton);
    //     logoutButton.addEventListener("click", () => {
    //         this.logOut();
    //     });
    //     const loginInfo = document.getElementById("logoutContainer");
    //     var paragraph = document.createElement("p");
    //     paragraph.id = "p-info";
    //     paragraph.textContent = `Logged in as ${accountId}`;
    //     loginInfo.append(paragraph);
       
        
    //     logoutContainer.style.display = "flex";
    // }

}

export default NearIntegration;
