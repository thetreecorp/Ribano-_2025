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
        this._initNear().then(() => {
            this.accountId = this._accountId;
            console.log(this._ownerId);

            if (this._ownerId) {

                this.showLoginInfo(this.accountId);
                this.createTokenButton();
                this.createAccountButton(
        this.ContractName );
            } else {
                
                this.createButtonLogin();
            }
        });
    }

    async _initNear() {
        const nearConfig = {
            networkId: "testnet",
            nodeUrl: "https://rpc.testnet.near.org",
            contractName: this.ContractName,
            walletUrl: "https://wallet.testnet.near.org",
        };
        const ContractName = this.ContractName;
        const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
        const near = await nearAPI.connect(Object.assign({ deps: { keyStore } }, nearConfig));
        this._keyStore = keyStore;
        this._nearConfig = nearConfig;
        this._near = near;

        this._walletConnection = new nearAPI.WalletConnection(near, ContractName);
        this._accountId = this._walletConnection.getAccountId();
        this._ownerId = this._accountId;

        this._account = this._walletConnection.account();
        this._contract = new nearAPI.Contract(this._account, ContractName, {
            viewMethods: ["get_required_deposit", "get_number_of_tokens", "get_tokens", "get_token"],
            changeMethods: ["create_token", "storage_deposit"],
        });
        await this._initYourToken();
        //await this.createSubAccountAndSendTokens(this._accountId, near);
        
        try {
            // const account = await this._walletConnection.account(this._accountId);
            
            // console.log(account);
            // await account.createAccount(
            //   "example44444.ctoken.testnet", // new account name
            //   "8hSHprDq2StXwMtNd43wDTXQYsjXcD4MJTXQYsjXccce", // public key for new account
            //   "10000000000000000000" // initial balance for new account in yoctoNEAR
            // );
          
        } catch (error) {
            console.error(error);
        }
    }

    
    /* ======================================== Function */
    async _initYourToken() {
        const args = ls.get(this.lsKeyToken);
        
        console.log('args/////////////////////////////');
       
        
        if (args) {
            const createToken = ls.get(this.lsKeyCreateToken);
            if (createToken) {
                ls.remove(this.lsKeyCreateToken);
                this.creating = true;
               // ls.set(this.lsKeyToken, 'cre');
                const requiredDeposit = await this.computeRequiredDeposit(args);
                if (requiredDeposit.eq(0)) {
                    await this._contract.create_token({ args }, BoatOfGas.toFixed(0)).then((result) => {
                        // Giao dịch hoàn thành thành công
                        console.log('result');
                        console.log(result);
                        // Xử lý kết quả và thực hiện các hành động khác
                      })
                      .catch((error) => {
                        // Giao dịch gặp lỗi
                        console.error(error);
                        // Xử lý lỗi và thực hiện các hành động khác
                      });
                                       
                } else {
                    this._ownerId = args.owner_id;
                    this.tokenId = args.metadata.symbol;
                    this.totalSupply = Big(args.total_supply).div(
                        Big(10).pow(parseInt(args.metadata.decimals))
                    );
                    this.tokenDecimals = args.metadata.decimals;
                    this.tokenName = args.metadata.name;
                    this.tokenIconBase64 = args.metadata.icon;
                    // Transaction was canceled.
                    
                    console.log('cancel');
                }
                ls.remove(this.lsKeyToken);
                this.creating = false;
                // this.setState({
                //     creating: false,
                //     readyForWalletWhitelist: true,
                //     tokenId: args.metadata.symbol,
                //     totalSupply: Big(args.total_supply).div(
                //         Big(10).pow(args.metadata.decimals)
                //     ),
                //     tokenDecimals: args.metadata.decimals,
                //     tokenName: args.metadata.name,
                //     tokenIconBase64: args.metadata.icon,
                // });
            }
        }
        this.updateRequiredDeposit();
        
    }

    async  createSubAccount(ContractName) {
//         try {
//     const nearConfig = {
//       networkId: 'testnet',
//       nodeUrl: 'https://rpc.testnet.near.org',
//     };

//     const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
//     const near = await nearAPI.connect(Object.assign({ deps: { keyStore } }, nearConfig));

//     const signerKey = 'ed25519:4v2cDMaeNKVgbGA6cHvN53GSdjiTEGG7pfu6gRpPjJd7MHPwhgqubA2s6zkkjgq9oMyDcugqr3kHMDqf8PEurW81'; // Thay thế bằng khóa bí mật của bạn
//     const inMemorySigner = new nearAPI.InMemorySigner(nearAPI.KeyPair.fromString(signerKey));
//     const publicKey = await inMemorySigner.getPublicKey(nearConfig.networkId);

//     const masterAccount = await near.account(this._accountId);
//     await masterAccount.createAccount(
//       'subAccountName' + this._accountId,
//       publicKey.toString(),
//       '1000000000000000000000000'
//     );

//     console.log('Tạo sub account thành công!');
//     console.log('Tên tài khoản:', subAccountName);
//     console.log('Khóa công khai:', publicKey.toString());
//   } catch (error) {
//     console.error('Lỗi:', error);
//   }
        try {const nearConfig = {
          networkId: 'testnet',
          nodeUrl: 'https://rpc.testnet.near.org',
        };
    
        const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
        const near = await nearAPI.connect(Object.assign({ deps: { keyStore } }, nearConfig));
    
        const keyPair = nearAPI.KeyPair.fromString('4v2cDMaeNKVgbGA6cHvN53GSdjiTEGG7pfu6gRpPjJd7MHPwhgqubA2s6zkkjgq9oMyDcugqr3kHMDqf8PEurW81');
        const publicKey = keyPair.getPublicKey();
    
        const walletConnection = new nearAPI.WalletConnection(near, ContractName);
        const accountId = walletConnection.getAccountId();
    
        const masterAccount = await near.account(accountId);
        await masterAccount.createAccount(
          'example-account2.testnet', // Tên tài khoản mới
          publicKey.toString(), // Khóa công khai cho tài khoản mới
          '1000000000000000000000000' // Số dư ban đầu cho tài khoản mới (10^24 yoctoNEAR)
        );
    
        console.log('Tạo sub account thành công!');
        console.log('Khóa công khai:', publicKey.toString());
      } catch (error) {
        console.error('Lỗi:', error);
      }
        
//         const keyStore = new nearAPI.keyStores.BrowserLocalStorageKeyStore();
//   const nearConfig = {
//     networkId: 'testnet',
//     nodeUrl: 'https://rpc.testnet.near.org',
//     keyStore: keyStore,
//   };

//   const near = await nearAPI.connect(nearConfig);
//   const keyPair = nearAPI.KeyPair.fromString('ed25519:4v2cDMaeNKVgbGA6cHvN53GSdjiTEGG7pfu6gRpPjJd7MHPwhgqubA2s6zkkjgq9oMyDcugqr3kHMDqf8PEurW81'); // Thay thế bằng khóa bí mật của bạn
//   const publicKey = keyPair.getPublicKey();

//   // Sử dụng publicKey hoặc keyPair trong các thao tác khác

//   console.log('Khóa công khai:', publicKey.toString());

        }
    
   
    
    async createSubAccountAndSendTokens(accountId, near) {

        
        // if(accountId == null) {
        //     this.showSnackbar('No account connect');
        //     return ;
        // }
        // const curve = 'ED25519';
        //     const keyPair = nearAPI.KeyPair.fromRandom(curve);

        
        
        
        // // Lấy public key từ cặp khóa
        // const publicKey = keyPair.publicKey;
        


        
        // const newAccountId = "example4455-account2.testnet";
        // const initialBalance = "10000000000000000000";
        
        // try {
        //     const outcome = await near.createAccount(newAccountId, publicKey, initialBalance);
        //     console.log("Sub account đã được tạo thành công!");
        //     console.log("Transaction hash:", outcome.transaction.hash);
        //     console.log(outcome);
        // } catch (error) {
        //     console.error("Không thể tạo sub account:", error);
        // }

        

    }


    async internalUpdateRequiredDeposit() {
        if (this._accountId) {
          const requiredDeposit = await this.computeRequiredDeposit();
          
        }
    }
    
    updateRequiredDeposit() {
        if (this._updateRequiredDeposit) {
          clearTimeout(this._updateRequiredDeposit);
          this._updateRequiredDeposit = null;
        }
        this._updateRequiredDeposit = setTimeout(
          () => this.internalUpdateRequiredDeposit(),
          250
        );
    }

    constructArgs() {
        return {
          owner_id: this._accountId,
          total_supply: Big(this.totalSupply)
            .mul(Big(10).pow(parseInt(this.tokenDecimals)))
            .round(0, 0)
            .toFixed(0),
          metadata: {
            spec: "ft-1.0.0",
            name: this.tokenName,
            symbol: this.tokenId,
            icon: this.tokenIconBase64,
            decimals: this.tokenDecimals,
          },
        };
    }

    showSnackbar(text) {
        const snackbar = document.createElement('div');
        snackbar.className = 'show';
        snackbar.id = 'snackbar';
        snackbar.textContent = text;
    
        document.body.appendChild(snackbar);
        // Add animation class to show the snackbar
        snackbar.classList.add('show');

        setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);

    }

    
    
    
    async createToken() {
       
        this.tokenName = this.getInputValue('token_name');
        this.totalSupply = this.getInputValue('total_supply');
        this.tokenDecimals = parseInt(this.getInputValue('token_decimals'));
        this.tokenIconBase64 = this.getInputValue('b64');
        //this.tokenIconBase64 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAAAXNSR0IArs4c6QAADRhJREFUeF7tnXm0TtUbxx+lQgmRIjKXlqkypqwsQxkyVciUIYWMociiAYuLyEzGQoZMq9G0tJrMNEirAUWDzBoMRfJbn90693fve88+Z5/3nOO9b53n33efPTzfvZ/9TPt5s1y4cOGCJBn99ttvkpKSItOnT1cz79q1qwwcOFCuvvrqJFuJSJZkBOD++++XlStXpmN2s2bNZMWKFREAYXPgm2++kZtvvtl2mK+//lpuuummsKcQaP9JdwJWr14t9evXt2XCqlWrpF69eoEyKOzOkg4AmNygQQNbvrzzzjtacMJmZLz9Jx0A0QmIF+qAvosACIiR8XYTARAv5wL6LgIgIEZa3fz6668yZ84c+eijj6RcuXLSpUsXuf766yVLliy2I8ULAPbmwYMH5aWXXpLPP/9c7rrrLunUqZPkypUr4BV56y6hl/D333+vNJovvvgiddZXXnml9OjRQ3r37i0FChTIsJp4APj5559lwoQJMnnyZDl16lRqn2XKlBG0qsKFC3vjWoCtEwrAc889J88//7ztcq655hp56qmnZMCAAel+9wrAqFGjZPTo0XL8+HHbcZ599llhHomihAFw7tw5JQIWLFjguPZbbrlFXnnlFSlfvrxcccUVYgLAn3/+KTt37pT27dvLl19+6dh/mzZtlAi8/PLLE4JBwgBgtexudqcJNW/eXJ0IHHG1a9e2/WT9+vXKIUefS5cuNelW9ckpSRQlFIC9e/fKbbfdJr///rvR+q+66irl6/n4449t299+++2Cr+jkyZNG/eXMmVM++eQTKVGihFH7MBqFAgAaB5rGsmXL5Pz58/Lggw9KhQoV5JJLLsmwBi7iBx54QD777DNBLF0MuuyyyxTwnJIbb7wxw5B///23mg/zv/TSS9X8EIE6zczPnEMBYO7cufLII49I2lDDxIkTpWfPntq5wgw0lQ0bNvhZj+u3qJ99+vRRTNXRpEmTpFevXul+nj17trqzgqbAAWAX6y60X375xVHvRkVcs2aNAo+2QVKePHkEJt5zzz2Cqqsj7JLcuXPb/szlHvRlHTgAH3zwgdx99922C3j77be1nsy0H5w5c0a6desmy5cvN5bnOoZyb7Dbp02bJtmzZ3fFFI9qw4YNbdux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";
        this.tokenId = this.getInputValue('token_symbol');

        const args = this.constructArgs();
        
        
        const requiredDeposit = await this.computeRequiredDeposit(args);
        
        //
        const tokenSym = this.tokenId.replace(/[^a-zA-Z\d]/, "");
        const tokenId  = tokenSym.toLowerCase();
        

        if (this.isValidTokenId(tokenSym)) {
            this._contract
              .get_token({ token_id: tokenId })
              .then(async (tokenDescription) => {
               
                if (tokenDescription !== null) {
                    this.showSnackbar('Token exist');
                    this.tokenAlreadyExists = true;
                }
                else {
              
                    ls.set(this.lsKeyToken, args);
                    ls.set(this.lsKeyCreateToken, true);
                 
                    await this._contract.storage_deposit(
                      {},
                      BoatOfGas.toFixed(0),
                      requiredDeposit.toFixed(0)
                    );
                }
              })
              .catch((e) => {
                this.showSnackbar('Error check token call');
              });
        }

        
    }
    async logOut() {
        this._walletConnection.signOut();
        this._accountId = null;
        this.accountId = null;
        this.clearElement("logoutContainer");
        this.createButtonLogin();
    }

    isValidAccountId(accountId) {
        return (
            accountId.length >= MinAccountIdLen &&
            accountId.length <= MaxAccountIdLen &&
            accountId.match(ValidAccountRe)
        );
    }
    
    isValidTokenId(tokenId) {
        tokenId = tokenId.toLowerCase();
        return (
          tokenId.match(ValidTokenIdRe) &&
          this.isValidAccountId(tokenId + "." + this.ContractName)
        );
    }


    async computeRequiredDeposit(args) {
        args = args || this.constructArgs();
        return Big(
          await this._contract.get_required_deposit({
            args,
            account_id: this._accountId,
          })
        );
    }

    async connectToWallet() {
        const appTitle = "Token Factory";
        await this._walletConnection.requestSignIn(this.ContractName, appTitle);
    }
    
    

    /* ======================================== End Function */

    getInputValue(inputId) {
        // Get the input element by ID
        var inputElement = document.getElementById(inputId);
        // Retrieve the value of the input element
        var value = inputElement.value;
        return value;
    }
    removeElement(ele) {
        const element = document.getElementById(ele);
        element.remove();
    }
    createButtonLogin() {
        const loginInfo = document.getElementById("loginWrap");
       
        const loginButton = document.createElement("button");
        loginButton.textContent = "Connect NEAR Wallet";
        loginButton.id = "connectButton";
        loginButton.className = "btn btn-primary";

       // const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
        loginInfo.appendChild(loginButton);
        loginButton.addEventListener("click", () => {
            this.connectToWallet();
        });
    }
    
    createTokenButton() {
        const tokenWrap = document.getElementById("create-token-wrap") || false;
       
        const createButton = document.createElement("p");
        createButton.textContent = "Create Token";
        createButton.id = "createTokenButton";
        createButton.className = "btn btn-warning mt-3 btn-rounded";

        // const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
        if (tokenWrap) {
            tokenWrap.appendChild(createButton);
            createButton.addEventListener("click", () => {
                this.createToken();
            });
        }
        
    }
    
    createAccountButton(ContractName) {
        const tokenWrap = document.getElementById("create-account-wrap") || false;
       
        const createButton = document.createElement("p");
        createButton.textContent = "Create Token";
        createButton.id = "createAccountButton";
        createButton.className = "btn btn-warning mt-3 btn-rounded";

        // const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
        if (tokenWrap) {
            tokenWrap.appendChild(createButton);
            createButton.addEventListener("click", () => {
                this.createSubAccount(ContractName);
            });
        }
        
    }

    clearElement(elementID){
        document.getElementById(elementID).innerHTML = "";
    }
   

    showLoginInfo(accountId) {
        const logoutButton = document.createElement("button");
        logoutButton.textContent = "Logout";
        logoutButton.id = "logoutButton";

        logoutButton.className = "btn btn-danger";

        const container = document.getElementById("logoutContainer"); // Replace 'logoutContainer' with the ID of the container element where you want to append the button
        container.appendChild(logoutButton);
        logoutButton.addEventListener("click", () => {
            this.logOut();
        });
        const loginInfo = document.getElementById("logoutContainer");
        var paragraph = document.createElement("p");
        paragraph.id = "p-info";
        paragraph.textContent = `Logged in as ${accountId}`;
        loginInfo.append(paragraph);
       
        
        logoutContainer.style.display = "flex";
    }

}

export default NearIntegration;
