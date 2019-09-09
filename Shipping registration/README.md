## Excersice for Estina

- We expect this to be unit tested. No need to implement any api, they can be mocked, just return a hard coded result.
- Order could be delivery by different shipping, when the order is ready to be shipped we need to send the address and order id to the shipping provider.

##Requirements

- Implement a function that registers the parcel, and it should be done for every shipping provider
                                                                       - UPS, send by api to upsfake.com/register -> order_id, country, street, city, post_code
                                                                       - OMNIVA - get pick up point id by calling the api (omnivafake.com/pickup/find ) : country, post code
                                                                                 - send (omnivafake.com/register) pickup_point_id and order id
                                                                       
                                                                       - DHL, send by api to dhlfake.com/register -> order_id, country, address, town, zip_code
                                                                                 
                                                                       - No need to use DIC you can just use static function to make it simpler
                                                                       - No need to persist anything, dont worry about dbs :)
                                                                       