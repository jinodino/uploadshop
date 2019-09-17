<!-- Modal -->
<div id="customerModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-container">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title">顧客情報</h4>
        </div>
        <div class="modal-body">
            <div class="info-container">
                <div class="info-title">
                    ID
                </div>
                <div class="info-id">
                    
                </div>
            </div>

            <div class="info-container">
                <div class="info-title">
                    NAME
                </div>
                <div class="info-name">
                    
                </div>
            </div>

            <div class="info-container">
                <div class="info-title">
                    Phone Number
                </div>
                <div class="info-phone">
                    
                </div>
            </div>

            <div class="info-container">
                <div class="info-title">
                    Order 
                </div>
                <div class="order-info">
                    <table class="order-info-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>ADDRESS</th>
                                <th>POST</th>
                            </tr>
                        </thead>
                        <tbody class="customer-order-list">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>



<div id="productModal" class="modal fade " role="dialog">
  <div class="modal-dialog modal-container">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title">商品情報</h4>
        </div>
        <div class="modal-body">
            <div class="body-container">
                <div class="info-container info-container1">
                    <div class="info-title">
                        Product Name
                    </div>
                    <div class="product-name">
                        
                    </div>
                    <div class="product-num-hidden" hidden></div>
                </div>

                <div class="info-container info-container2">
                    <div class="info-title">
                        Price
                    </div>
                    <div class="product-price">
                        
                    </div>
                </div>

                <div class="info-container info-container3">
                    <div class="info-title">
                        Memo
                    </div>
                    <div class="product-memo">
                        
                    </div>
                </div>

                <div class="info-container info-container4">
                    <div class="info-title">
                        Image
                    </div>
                    <div class="img-change">

                    </div>
                    <div class="product-img">
                        <img class="product-img-tag" src="" alt="Smiley face">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="change-button-frame">
                <button type="button" class="btn btn-default" onclick="changeInfo()">Change</button>
            </div>
            <div class="close-button-frame">
                <button type="button" class="btn btn-default" onclick="closeModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

  </div>
</div>


