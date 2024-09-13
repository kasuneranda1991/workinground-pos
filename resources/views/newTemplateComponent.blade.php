@extends('master')
@section('pageurl') Home > Received Recervation @stop
@section('pagetitle') Your reservation history @stop
@section('header') 
<link rel="stylesheet" type="text/css" href="https://designrevision.com/demo/shards-dashboards/styles/shards-dashboards.1.3.1.min.css">
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="https://designrevision.com/demo/shards-dashboards/styles/shards-dashboards.1.3.1.min.css">
<link rel="stylesheet" type="text/css" href="https://buttons.github.io/buttons.js">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
@stop
@section('content')
<div class="col-lg-5 mb-4">
                <div class="card card-small go-stats">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Goals Overview</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body py-0">
                    <ul class="list-group list-group-small list-group-flush">
                      <li class="list-group-item d-flex row px-0">
                        <div class="col-lg-6 col-md-8 col-sm-8 col-6">
                          <h6 class="go-stats__label mb-1">Newsletter Signups</h6>
                          <div class="go-stats__meta">
                            <span class="mr-2">
                              <strong>291</strong> Completions</span>
                            <span class="d-block d-sm-inline">
                              <strong class="text-success">$192.00</strong> Value</span>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-6 d-flex">
                          <div class="go-stats__value text-right ml-auto">
                            <h6 class="go-stats__label mb-1">57.2%</h6>
                            <span class="go-stats__meta">Conversion Rate</span>
                          </div>
                          <div class="go-stats__chart d-flex ml-auto">
                            <canvas style="width: 45px; height: 45px; display: block;" class="my-auto" id="analytics-overview-goal-completion-1" width="45" height="45"></canvas>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item d-flex row px-0">
                        <div class="col-lg-6 col-md-8 col-sm-8 col-6">
                          <h6 class="go-stats__label mb-1">Social Shares</h6>
                          <div class="go-stats__meta">
                            <span class="mr-2">
                              <strong>451</strong> Completions</span>
                            <span class="d-block d-sm-inline">
                              <strong class="text-success">$0.00</strong> Value</span>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-6 d-flex">
                          <div class="go-stats__value text-right ml-auto">
                            <h6 class="go-stats__label mb-1">45.5%</h6>
                            <span class="go-stats__meta">Conversion Rate</span>
                          </div>
                          <div class="go-stats__chart d-flex ml-auto">
                            <canvas style="width: 45px; height: 45px; display: block;" class="my-auto" id="analytics-overview-goal-completion-2" width="45" height="45"></canvas>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item d-flex row px-0">
                        <div class="col-lg-6 col-md-8 col-sm-8 col-6">
                          <h6 class="go-stats__label mb-1">eBook Downloads</h6>
                          <div class="go-stats__meta">
                            <span class="mr-2">
                              <strong>12</strong> Completions</span>
                            <span class="d-block d-sm-inline">
                              <strong class="text-success">$129.11</strong> Value</span>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-6 d-flex">
                          <div class="go-stats__value text-right ml-auto">
                            <h6 class="go-stats__label mb-1">5.2%</h6>
                            <span class="go-stats__meta">Conversion Rate</span>
                          </div>
                          <div class="go-stats__chart d-flex ml-auto">
                            <canvas style="width: 45px; height: 45px; display: block;" class="my-auto" id="analytics-overview-goal-completion-3" width="45" height="45"></canvas>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item d-flex row px-0">
                        <div class="col-lg-6 col-md-8 col-sm-8 col-6">
                          <h6 class="go-stats__label mb-1">Account Creations</h6>
                          <div class="go-stats__meta">
                            <span class="mr-2">
                              <strong>281</strong> Completions</span>
                            <span class="d-block d-sm-inline">
                              <strong class="text-success">$218.12</strong> Value</span>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-6 d-flex">
                          <div class="go-stats__value text-right ml-auto">
                            <h6 class="go-stats__label mb-1">30.2%</h6>
                            <span class="go-stats__meta">Conversion Rate</span>
                          </div>
                          <div class="go-stats__chart d-flex ml-auto">
                            <canvas style="width: 45px; height: 45px; display: block;" class="my-auto" id="analytics-overview-goal-completion-4" width="45" height="45"></canvas>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="card-footer border-top">
                    <div class="row">
                      <div class="col">
                        <select class="custom-select custom-select-sm" style="max-width: 130px;">
                          <option selected="">Last Week</option>
                          <option value="1">Today</option>
                          <option value="2">Last Month</option>
                          <option value="3">Last Year</option>
                        </select>
                      </div>
                      <div class="col text-right view-report">
                        <a href="#">View full report →</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- new -->
              <div class="col-lg-12 mb-4">
                <div class="card card-small lo-stats h-100">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Latest Orders</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
                    <div class="container-fluid px-0">
                      <table class="table mb-0">
                        <thead class="py-2 bg-light text-semibold border-bottom">
                          <tr>
                            <th>Details</th>
                            <th></th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Items</th>
                            <th class="text-center">Total</th>
                            <th class="text-right">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="images/sales-overview/product-order-1.jpg">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>#19280</span>
                              <span>21 February 2018 20:32</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success">Complete</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center">12</td>
                            <td class="lo-stats__total text-center text-success">$199</td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">Cancel</button>
                                <button type="button" class="btn btn-sm btn-white">Edit</button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="images/sales-overview/product-order-2.jpg">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>#19279</span>
                              <span>21 February 2018 20:32</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-warning">Pending</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center">7</td>
                            <td class="lo-stats__total text-center text-success">$612</td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">Cancel</button>
                                <button type="button" class="btn btn-sm btn-white">Edit</button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="images/sales-overview/product-order-3.jpg">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>#19278</span>
                              <span>21 February 2018 20:32</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-danger">Canceled</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center">18</td>
                            <td class="lo-stats__total text-center text-success">$1211</td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">Cancel</button>
                                <button type="button" class="btn btn-sm btn-white">Edit</button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="lo-stats__image">
                              <img class="border rounded" src="images/sales-overview/product-sweaters.jpg">
                            </td>
                            <td class="lo-stats__order-details">
                              <span>#19277</span>
                              <span>21 February 2018 20:32</span>
                            </td>
                            <td class="lo-stats__status">
                              <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success">Complete</span>
                              </div>
                            </td>
                            <td class="lo-stats__items text-center">12</td>
                            <td class="lo-stats__total text-center text-success">$199</td>
                            <td class="lo-stats__actions">
                              <div class="btn-group d-table ml-auto" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-white">Cancel</button>
                                <button type="button" class="btn btn-sm btn-white">Edit</button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer border-top">
                    <div class="row">
                      <div class="col">
                        <select class="custom-select custom-select-sm" style="max-width: 130px;">
                          <option selected="">Last Week</option>
                          <option value="1">Today</option>
                          <option value="2">Last Month</option>
                          <option value="3">Last Year</option>
                        </select>
                      </div>
                      <div class="col text-right view-report">
                        <a href="#">View full report →</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!-- new section -->
<div class="card card-small user-activity mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">User Activity</h6>
                    <div class="block-handle"></div>
                  </div>
                  <div class="card-body p-0">
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">23 Minutes ago</span>
                        <p>Assigned himself to the <a href="#">Shards Dashboards</a> project.</p>
                      </div>
                      <div class="user-activity__item__action ml-auto">
                        <button class="ml-auto btn btn-sm btn-white">View Project</button>
                      </div>
                    </div>
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">2 Hours ago</span>
                        <p>Marked <a href="#">7 tasks</a> as <span class="badge badge-pill badge-outline-success">Complete</span> inside the <a href="#">DesignRevision</a> project.</p>
                      </div>
                    </div>
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">3 Hours and 10 minutes ago</span>
                        <p>Added <a href="#">Jack Nicholson</a> and <a href="#">3 others</a> to the <a href="#">DesignRevision</a> team.</p>
                      </div>
                      <div class="user-activity__item__action ml-auto">
                        <button class="ml-auto btn btn-sm btn-white">View Team</button>
                      </div>
                    </div>
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">2 Days ago</span>
                        <p>Opened <a href="#">3 issues</a> in <a href="#">2 projects</a>.</p>
                      </div>
                    </div>
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">2 Days ago</span>
                        <p>Added <a href="#">3 new tasks</a> to the <a href="#">DesignRevision</a> project:</p>
                        <ul class="user-activity__item__task-list mt-2">
                          <li>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="user-activity-task-1">
                              <label class="custom-control-label" for="user-activity-task-1">Fix blog pagination issue.</label>
                            </div>
                          </li>
                          <li>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="user-activity-task-2">
                              <label class="custom-control-label" for="user-activity-task-2">Remove extra padding from blog post container.</label>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="user-activity__item pr-3 py-3">
                      <div class="user-activity__item__icon">
                        <i class="material-icons"></i>
                      </div>
                      <div class="user-activity__item__content">
                        <span class="text-light">2 Days ago</span>
                        <p>Marked <a href="#">3 tasks</a> as <span class="badge badge-pill badge-outline-danger">Invalid</span> inside the <a href="#">Shards Dashboards</a> project.</p>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer border-top">
                    <button class="btn btn-sm btn-white d-table mx-auto">Load More</button>
                  </div>
                </div>
                <!-- new element -->
                <div class="card card-small edit-user-details mb-4">
                  <div class="card-header p-0">
                    <div class="edit-user-details__bg">
                      <img src="logo/logo-poster.png" alt="User Details Background Image">
                      <label class="edit-user-details__change-background">
                        <i class="material-icons mr-1"></i> Change Background Photo <input class="d-none" type="file">
                      </label>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="border-bottom clearfix d-flex">
                      <ul class="nav nav-tabs border-0 mt-auto mx-4 pt-2">
                        <li class="nav-item">
                          <a class="nav-link active" href="#">General</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Projects</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Collaboration</a>
                        </li>
                      </ul>
                    </div>
                    <form action="#" class="py-4">
                      <div class="form-row mx-4">
                        <div class="col mb-3">
                          <h6 class="form-text m-0">General</h6>
                          <p class="form-text text-muted m-0">Setup your general profile details.</p>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <div class="col-lg-8">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="firstName">First Name</label>
                              <input type="text" class="form-control" id="firstName" value="Sierra">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="lastName">Last Name</label>
                              <input type="text" class="form-control" id="lastName" value="Brooks">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="userLocation">Location</label>
                              <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="material-icons"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="Remote">
                              </div>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="phoneNumber">Phone Number</label>
                              <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="material-icons"></i>
                                  </div>
                                </div>
                                <input type="text" class="form-control" id="phoneNumber" value="+40 1234 567 890">
                              </div>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="emailAddress">Email</label>
                              <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="material-icons"></i>
                                  </div>
                                </div>
                                <input type="email" class="form-control" id="emailAddress">
                              </div>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="displayEmail">Display Email Publicly</label>
                              <select class="custom-select">
                                <option value="1" selected="">Yes, display my email</option>
                                <option value="2">No, do not display my email.</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <label for="userProfilePicture" class="text-center w-100 mb-4">Profile Picture</label>
                          <div class="edit-user-details__avatar m-auto">
                            <img src="user/user.png" alt="User Avatar">
                            <label class="edit-user-details__avatar__change">
                              <i class="material-icons mr-1"></i>
                              <input type="file" id="userProfilePicture" class="d-none">
                            </label>
                          </div>
                          <button class="btn btn-sm btn-white d-table mx-auto mt-4"><i class="material-icons"></i> Upload Image</button>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <div class="form-group col-md-6">
                          <label for="userBio">Bio</label>
                          <textarea style="min-height: 87px;" id="userBio" name="userBio" class="form-control">I'm a design focused engineer.</textarea>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="userTags">Tags</label>
                          <div class="bootstrap-tagsinput"> <span class="tag label label-info">UI Design<span data-role="remove"></span></span> <span class="tag label label-info"> React JS<span data-role="remove"></span></span> <span class="tag label label-info"> HTML &amp; CSS<span data-role="remove"></span></span> <span class="tag label label-info"> JavaScript<span data-role="remove"></span></span> <span class="tag label label-info"> Bootstrap 4<span data-role="remove"></span></span> <span class="tag label label-info">boot<span data-role="remove"></span></span> <input type="text" placeholder="" size="1"></div><input id="userTags" name="userTags" value="User Experience,UI Design, React JS, HTML &amp; CSS, JavaScript, Bootstrap 4" class="d-none" style="display: none;">
                        </div>
                      </div>
                      <hr>
                      <div class="form-row mx-4">
                        <div class="col mb-3">
                          <h6 class="form-text m-0">Social</h6>
                          <p class="form-text text-muted m-0">Setup your social profiles info.</p>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <div class="form-group col-md-4">
                          <label for="socialFacebook">Facebook</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-facebook-f"></i>
                              </div>
                            </div>
                            <input type="text" class="form-control" id="socialFacebook">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="socialTwitter">Twitter</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-twitter"></i>
                              </div>
                            </div>
                            <input type="email" class="form-control" id="socialTwitter">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="socialGitHub">GitHub</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-github"></i>
                              </div>
                            </div>
                            <input type="text" class="form-control" id="socialGitHub">
                          </div>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <div class="form-group col-md-4">
                          <label for="socialSlack">Slack</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-slack"></i>
                              </div>
                            </div>
                            <input type="email" class="form-control" id="socialSlack">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="socialDribbble">Dribbble</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-dribbble"></i>
                              </div>
                            </div>
                            <input type="email" class="form-control" id="socialDribbble">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="socialGoogle">Google Plus+</label>
                          <div class="input-group input-group-seamless">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fab fa-google-plus-g"></i>
                              </div>
                            </div>
                            <input type="email" class="form-control" id="socialGoogle">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-row mx-4">
                        <div class="col mb-3">
                          <h6 class="form-text m-0">Notifications</h6>
                          <p class="form-text text-muted m-0">Setup which notifications would you like to receive.</p>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <label for="conversationsEmailsToggle" class="col col-form-label"> Conversations <small class="form-text text-muted"> Sends notification emails with updates for the conversations you are participating in or if someone mentions you. </small>
                        </label>
                        <div class="col d-flex">
                          <div class="custom-control custom-toggle ml-auto my-auto">
                            <input type="checkbox" id="conversationsEmailsToggle" class="custom-control-input" checked="">
                            <label class="custom-control-label" for="conversationsEmailsToggle"></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <label for="newProjectsEmailsToggle" class="col col-form-label"> New Projects <small class="form-text text-muted"> Sends notification emails when you are invited to a new project. </small>
                        </label>
                        <div class="col d-flex">
                          <div class="custom-control custom-toggle ml-auto my-auto">
                            <input type="checkbox" id="newProjectsEmailsToggle" class="custom-control-input">
                            <label class="custom-control-label" for="newProjectsEmailsToggle"></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <label for="vulnerabilitiesEmailsToggle" class="col col-form-label"> Vulnerability Alerts <small class="form-text text-muted"> Sends notification emails when everything goes down and there's no hope left whatsoever. </small>
                        </label>
                        <div class="col d-flex">
                          <div class="custom-control custom-toggle ml-auto my-auto">
                            <input type="checkbox" id="vulnerabilitiesEmailsToggle" class="custom-control-input" checked="">
                            <label class="custom-control-label" for="vulnerabilitiesEmailsToggle"></label>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-row mx-4">
                        <div class="col mb-3">
                          <h6 class="form-text m-0">Change Password</h6>
                          <p class="form-text text-muted m-0">Change your current password.</p>
                        </div>
                      </div>
                      <div class="form-row mx-4">
                        <div class="form-group col-md-4">
                          <label for="firstName">Old Password</label>
                          <input type="text" class="form-control" id="firstName" placeholder="Old Password">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="lastName">New Password</label>
                          <input type="text" class="form-control" id="lastName" placeholder="New Password">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="emailAddress">Repeat New Password</label>
                          <input type="email" class="form-control" id="emailAddress" placeholder="Repeat New Password">
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer border-top">
                    <a href="#" class="btn btn-sm btn-accent ml-auto d-table mr-3">Save Changes</a>
                  </div>
                </div>
                <!-- new element -->
                <div class="main-content-container container-fluid px-4 my-auto h-100">
            <div class="row no-gutters h-100">
              <div class="col-lg-3 col-md-5 auth-form mx-auto my-auto">
                <div class="card">
                  <div class="card-body">
                    <img class="auth-form__logo d-table mx-auto mb-3" src="images/shards-dashboards-logo.svg" alt="Shards Dashboards - Register Template">
                    <h5 class="auth-form__title text-center mb-4">Access Your Account</h5>
                    <form>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>
                      <div class="form-group mb-3 d-table mx-auto">
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="customCheck2">
                          <label class="custom-control-label" for="customCheck2">Remember me for 30 days.</label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-pill btn-accent d-table mx-auto">Access Account</button>
                    </form>
                  </div>
                  <div class="card-footer border-top">
                    <ul class="auth-form__social-icons d-table mx-auto">
                      <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                      <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fab fa-github"></i></a></li>
                      <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="auth-form__meta d-flex mt-4">
                  <a href="forgot-password.html">Forgot your password?</a>
                  <a class="ml-auto" href="register.html">Create new account?</a>
                </div>
              </div>
            </div>
          </div>
          <!-- new element  transaction history-->
          <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0"></label></div><table class="transaction-history d-none dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 823px;">
              <thead>
                <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 10.8px;" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120.8px;" aria-label="Date: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 86.8px;" aria-label="Customer: activate to sort column ascending">Customer</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 49.8px;" aria-label="Products: activate to sort column ascending">Products</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 46.8px;" aria-label="Status: activate to sort column ascending">Status</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 35.8px;" aria-label="Total: activate to sort column ascending">Total</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 150.8px;" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
              </thead>
              <tbody>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
              <tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">1</td>
                  <td>October 31st 2017 <span class="text-sm">02:10 PM</span>
                  </td>
                  <td>Mrs. Chauncey McDermott</td>
                  <td>68010</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td>
                    <span class="text-success">$269.75</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="even">
                  <td tabindex="0" class="sorting_1">2</td>
                  <td>May 31st 2017 <span class="text-sm">08:39 PM</span>
                  </td>
                  <td>Keon Heller</td>
                  <td>44566</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td>
                    <span class="text-success">$536.49</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">3</td>
                  <td>January 31st 2018 <span class="text-sm">02:10 PM</span>
                  </td>
                  <td>Jordy Nicolas</td>
                  <td>86145</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td>
                    <span class="text-success">$509.64</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="even">
                  <td tabindex="0" class="sorting_1">4</td>
                  <td>September 5th 2017 <span class="text-sm">04:39 PM</span>
                  </td>
                  <td>Keara Keeling</td>
                  <td>86554</td>
                  <td>
                    <span class="text-success">Complete</span>
                  </td>
                  <td>
                    <span class="text-success">$922.24</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">5</td>
                  <td>February 17th 2018 <span class="text-sm">03:24 PM</span>
                  </td>
                  <td>Terrence Hahn</td>
                  <td>25690</td>
                  <td>
                    <span class="text-success">Complete</span>
                  </td>
                  <td>
                    <span class="text-success">$325.91</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="even">
                  <td tabindex="0" class="sorting_1">6</td>
                  <td>May 30th 2017 <span class="text-sm">04:39 PM</span>
                  </td>
                  <td>Ms. Yoshiko Feil</td>
                  <td>4818</td>
                  <td>
                    <span class="text-danger">Canceled</span>
                  </td>
                  <td>
                    <span class="text-success">$298.15</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">7</td>
                  <td>July 24th 2017 <span class="text-sm">08:39 PM</span>
                  </td>
                  <td>Zachariah Pfannerstill</td>
                  <td>90722</td>
                  <td>
                    <span class="text-danger">Canceled</span>
                  </td>
                  <td>
                    <span class="text-success">$906.18</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="even">
                  <td tabindex="0" class="sorting_1">8</td>
                  <td>March 17th 2017 <span class="text-sm">04:39 PM</span>
                  </td>
                  <td>Mrs. Caleigh Steuber</td>
                  <td>45376</td>
                  <td>
                    <span class="text-success">Complete</span>
                  </td>
                  <td>
                    <span class="text-success">$871.82</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">9</td>
                  <td>December 5th 2017 <span class="text-sm">03:24 PM</span>
                  </td>
                  <td>Lincoln Hahn V</td>
                  <td>43011</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td>
                    <span class="text-success">$541.01</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr><tr role="row" class="even">
                  <td tabindex="0" class="sorting_1">10</td>
                  <td>January 17th 2018 <span class="text-sm">02:10 PM</span>
                  </td>
                  <td>Edythe Stanton</td>
                  <td>40309</td>
                  <td>
                    <span class="text-warning">Pending</span>
                  </td>
                  <td>
                    <span class="text-success">$214.59</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Table row actions">
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                      <button type="button" class="btn btn-white">
                        <i class="material-icons"></i>
                      </button>
                    </div>
                  </td>
                </tr></tbody>
            </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 100 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0">2</a><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0">3</a><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="4" tabindex="0">4</a><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="5" tabindex="0">5</a><span class="ellipsis">…</span><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="6" tabindex="0">10</a></span><a class="paginate_button next" aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0" id="DataTables_Table_0_next">Next</a></div></div>

            <!-- new element calender -->
            
@stop
@section('script')
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
<script src="https://designrevision.com/demo/shards-dashboards/scripts/extras.1.3.1.min.js"></script>
<script src="https://designrevision.com/demo/shards-dashboards/scripts/shards-dashboards.1.3.1.min.js"></script>
<!-- <script src="https://designrevision.com/demo/shards-dashboards/scripts/shards-dashboards.1.3.1.min.js"></script> -->
@stop