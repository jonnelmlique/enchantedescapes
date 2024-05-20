<div class="button-add-employee">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">add employee</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add employee</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="addemployee.php" enctype="multipart/form-data">
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">img:</label>
                                    <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Name">
                                  </div>

                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Address:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Address">
                                  </div>

                                  
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Age:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Age">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Phone:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Phone">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Start Date:</label>
                                    <input type="date" class="form-control" id="recipient-name" name="StartDate">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Status:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Status">
                                  </div>
                                  <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">add employee</button>
                              </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>