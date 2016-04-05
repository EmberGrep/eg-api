<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <!-- NAME: MINIMAL -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }}</title>

  @include('emails/_style')
</head>

<body>
  <center>
    <table id="bodyTable" border="0" width="100%" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td id="bodyCell">
            <!-- BEGIN TEMPLATE // -->
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td>
                    <!-- BEGIN PREHEADER // -->
                    <table id="templatePreheader" border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>
                            <table class="templateContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td class="preheaderContainer"> </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- // END PREHEADER -->
                  </td>
                </tr>
                <tr>
                  <td>
                    <!-- BEGIN HEADER // -->
                    <table id="templateHeader" border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>
                            <table class="templateContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td class="headerContainer">
                                    <table class="mcnTextBlock" border="0" width="100%" cellspacing="0" cellpadding="0">
                                      <tbody class="mcnTextBlockOuter">
                                        <tr>
                                          <td class="mcnTextBlockInner">
                                            <table class="mcnTextContentContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                                              <tbody>
                                                <tr>
                                                  <td class="mcnTextContent">
                                                    <h1>EmberGrep</h1>

                                                    <h3>{{ $title }}</h3>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- // END HEADER -->
                  </td>
                </tr>
                <tr>
                  <td>
                    <!-- BEGIN BODY // -->
                    <table id="templateBody" border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>
                            <table class="templateContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td class="bodyContainer">
                                    <table class="mcnTextBlock" border="0" width="100%" cellspacing="0" cellpadding="0">
                                      <tbody class="mcnTextBlockOuter">
                                        <tr>
                                          <td class="mcnTextBlockInner">
                                            <table class="mcnTextContentContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                                              <tbody>
                                                <tr>
                                                  <td class="mcnTextContent">
                                                    @yield('body')
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- // END BODY -->
                  </td>
                </tr>
                <tr>
                  <td>
                    <!-- BEGIN FOOTER // -->
                    <table id="templateFooter" border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td>
                            <table class="templateContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td class="footerContainer">
                                    <table class="mcnTextBlock" border="0" width="100%" cellspacing="0" cellpadding="0">
                                      <tbody class="mcnTextBlockOuter">
                                        <tr>
                                          <td class="mcnTextBlockInner">
                                            <table class="mcnTextContentContainer" border="0" width="600" cellspacing="0" cellpadding="0">
                                              <tbody>
                                                <tr>
                                                  <td class="mcnTextContent">
                                                    <em>Copyright 2016 EmberGrep, All rights reserved.</em>
                                                    <br>
                                                    <br>
                                                    <strong>Our mailing address is:</strong>
                                                    <br> 2310 12th Ave South #212 NASHVILLE, TN, 37204
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- // END FOOTER -->
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- // END TEMPLATE -->
          </td>
        </tr>
      </tbody>
    </table>
  </center>
</body>

</html>
