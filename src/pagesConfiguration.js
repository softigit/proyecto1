(function(emb){

    /*
    * Flow object example
    * flowName
    *     finalized // Indicates whether or not thw user has finalized the flow. Default to false. Do not override it.
    *     whereToRedirectAfterRefreshing // safe hash where the user will be redirected after refreshing. Default to empty hash
    *     shouldBeShutter // Indicates whether or not the flow should be shuttered. Default to true.
    *     pages // array of pages within the flow
    *         $el // jQuery reference to page element.
    *         type // type of the page. Possible values:
    *                                     entry-point: Page that initializes the flow
    *                                     confirm: Page that closes the flow
    *                                     bulk (default): Any page inbetween entry-points and confirm pages.
     */

    var config = {
        flows:{
            safeHashes: {
                whereToRedirectAfterRefreshing: null,
                shouldBeShuttered: false,
                pages: [
                    {
                        $el: $('#paytransfer')
                    },
                    {
                        $el: $('#accounts')
                    },
                    {
                        $el: $('#quickpayoptions')
                    },
                    {
                        $el: $('#paybills-r2')
                    },
                    {
                        $el: $('#alertsmenu')
                    },
                    {
                        $el: $('#qp')
                    },
                    {
                        $el: $('#quote')
                    },
                    {
                        $el: $('#faqs')
                    },
                    {
                        $el: $('#more')
                    },
                    {
                        $el: $('#atmbranchlocations')
                    },
                    {
                        $el: $('#agreementList')
                    },
                    {
                        $el: $('#moreAgreementContent')
                    }
                ]
            },

            agreement: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#',
                pages: [
                    {
                        $el: $('#agreementDialog')
                    },
                    {
                        $el: $('#agreementContent')
                    },
                    {
                        $el: $('#agreementConfirm')
                    }
                ]
            },

            paybill: {
                whereToRedirectAfterRefreshing: '#paytransfer',
                shouldBeShuttered: true,
                pages: [
                    {
                        $el: $('#paybillsselectpayee-r2'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#paybillsconfirmpayment-r2'),
                        type: 'confirm'
                    },
                    {
                        $el: $('#paybillsschedulepayment-r2')
                    },
                    {
                        $el: $('#paybillsverifypayment-r2')
                    },
                    {
                        $el: $('#paybillauthorize')
                    },
                    {
                        $el: $('#paybillauthorize-r2')
                    },
                    {
                        $el: $('#paybills-confirm-cancel-r2'),
                        type: 'confirm'
                    }
                ]
            },

            transfer: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#paytransfer',
                pages: [
                    {
                        $el: $('#transfermoney'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#scheduletransfer'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#verifytransfer')
                    },
                    {
                        $el: $('#transfer-calendar')
                    },
                    {
                        $el: $('#transfercomplete'),
                        type: 'confirm'
                    }
                ]
            },

            quickpayMoneyFlow: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#quickpayoptions',
                pages: [
                    {
                        $el: $('#quickpayoptions'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#quickpaytodolist'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#qpsendmoneyenter')
                    },
                    {
                        $el: $('#quickpay-send-money-recipients')
                    },
                    {
                        $el: $('#qpsendmoneyverify')
                    },
                    {
                        $el: $('#qprequestmoneyenter')
                    },
                    {
                        $el: $('#quickpay-request-money-recipients')
                    },
                    {
                        $el: $('#qprecipientsnotification')
                    },
                    {
                        $el: $('#qprequestmoneyverify')
                    },
                    {
                        $el: $('#qprequestmoneyconfirm'),
                        type: 'confirm'
                    },
                    {
                        $el: $('#qpsendmoneyconfirm'),
                        type: 'confirm'
                    }
                ]
            },

            quickpay: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#quickpayoptions',
                pages: [
                    {
                        $el: $('#quickpayrecipients')
                    },
                    {
                        $el: $('#quickpaytransactiondetails')
                    },
                    {
                        $el: $('#quickpayaddrecipient')
                    },
                    {
                        $el: $('#quickpayactivity')
                    },
                    {
                        $el: $('#quickpayrecipientdetails')
                    },
                    {
                        $el: $('#quickpayeditrecipient')
                    },
                    {
                        $el: $('#qppendingtransactions')
                    },
                    {
                        $el: $('#qppendingtransactiondetails')
                    },
                    {
                        $el: $('#quickpay-calendar')
                    },
                    {
                        $el: $('#qppendingcancelconfirmation')
                    }
                ]
            },

            wire: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#paytransfer',
                pages: [
                    {
                        $el: $('#wireindex'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#wireschedulepayment')
                    },
                    {
                        $el: $('#wireverifypayment')
                    },
                    {
                        $el: $('#wire-calendar')
                    },
                    {
                        $el: $('#wireconfirmdialog')
                    },
                    {
                        $el: $('#wireagreement')
                    },
                    {
                        $el: $('#wire-confirm-cancel'),
                        type: 'confirm'
                    },
                    {
                        $el: $('#wirecanceldialog')
                    },
                    {
                        $el: $('#mm-payment-activity-duplicate-dialog')
                    },
                    {
                        $el: $('#wireconfirmpayment'),
                        type: 'confirm'
                    }
                ]
            },

            locations: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#atmbranchlocations',
                pages: [
                    {
                        $el: $('#locationdetailpage')
                    },
                    {
                        $el: $('#locationResults')
                    }
                ]
            },

            payees: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#paybills-r2',
                pages: [
                    {
                        $el: $('#paybillsManagePayee-r2'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#billpayaddpayee-r2')
                    },
                    {
                        $el: $('#billpayaddpayeedetails-r2')
                    },
                    {
                        $el: $('#billpayaddpayeedetailsVerify-r2')
                    },
                    {
                        $el: $('#paybillsManagePayeeSearchResults-r2')
                    },
                    {
                        $el: $('#paybillsEditPayeeR2')
                    },
                    {
                        $el: $('#bpEditPayeeDetailName-r2')
                    },
                    {
                        $el: $('#billpayeditpayeedetailsVerifyR2')
                    },
                    {
                        $el: $('#bp-add-payee-confirm-dialog-r2'),
                        type: 'confirm'
                    },
                    {
                        $el: $('#billpayaddpayeedetailsVerify-r2')
                    }
                ]
            },

            accounts: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#accounts',
                pages: [
                    {
                        $el: $('#accountdetails')
                    },
                    {
                        $el: $('#producttradeddetails')
                    },
                    {
                        $el: $('#accountposition')
                    },
                    {
                        $el: $('#accountpositiondetails')
                    },
                    {
                        $el: $('#accounttransaction')
                    },
                    {
                        $el: $('#accountactivity')
                    },
                    {
                        $el: $('#accountscustomerlist')
                    },
                    {
                        $el: $('#rewarddetails')
                    },
                    {
                        $el: $('#accountsummary')
                    },
                    {
                        $el: $('#offerdetails')
                    },
                    {
                        $el: $('#legal-info')
                    },
                    {
                        $el: $('#legal-info-details')
                    },
                    {
                        $el: $('#cpc-disclosures')
                    },
                    {
                        $el: $('#investmentAccountTransactionDetail')
                    },
                    {
                        $el: $('#accountsAnnouncements')
                    },
                    {
                        $el: $('#redeemrewardfailed')
                    },
                    {
                        $el: $('#indicatorDetails')
                    }
                ]
            },

            alerts: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#alertsmenu',
                pages: [
                    {
                        $el: $('#alertshistory')
                    },
                    {
                        $el: $('#alertsmanage')
                    },
                    {
                        $el: $('#alertssubscriptionupdate')
                    }
                ]
            },

            qpSelectBank: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#qp',
                pages: [
                    {
                        $el: $('#qpselectbank')
                    }
                ]
            },

            more: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#more',
                pages: [
                    {
                        $el: $('#disclosures')
                    },
                    {
                        $el: $('#disclosure-details')
                    }
                ]
            },

            faqs: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#faqs',
                pages: [
                    {
                        $el: $('#faqs-questions')
                    },
                    {
                        $el: $('#faqs-question-detail')
                    }
                ]
            },

            quote: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#quote',
                pages: [
                    {
                        $el: $('#article')
                    }
                ]
            },

            contactList: {
                shouldBeShuttered: false,
                whereToRedirectAfterRefreshing: '#get-more-contacts-list',
                pages: [
                    {
                        $el: $('#get-more-contacts-details')
                    }
                ]
            },

            mmPaymentActivity: {
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: '#paytransfer',
                pages: [
                    {
                        $el: $('#mmpaymentactivity'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#mmpaymentactivitydetails'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#mmpaymentactivity-r2'),
                        type: 'entry-point'
                    },
                    {
                        $el: $('#mmpaymentactivitydetails-r2'),
                        type: 'entry-point'
                    }
                ]
            }
        }
    };

    //add default values to user config
    emb.pagesConfiguration = (function(config){
        
        var defaultFlow = {
                finalized: false,
                shouldBeShuttered: true,
                whereToRedirectAfterRefreshing: ""
            },
            defaultPage = {
                $el: null,
                type: 'bulk'
            },
            newConfig = {
                flows: {}
            };

        _.each( config.flows, function(flow, flowName){
            newConfig.flows[flowName] = {};
            _.extend(newConfig.flows[flowName], defaultFlow, flow);

            newConfig.flows[flowName].pages = [];
            _.each(flow.pages, function(page){
                newConfig.flows[flowName].pages.push( _.extend({}, defaultPage, page) );
            });
        } );

        return newConfig;
        
    }(config));
    
}(emb));