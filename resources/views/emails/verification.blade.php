<style media="all">
  html, body, div, span, applet, object, iframe,
  h1, h2, h3, h4, h5, h6, p, blockquote, pre,
  a, abbr, acronym, address, big, cite, code,
  del, dfn, em, img, ins, kbd, q, s, samp,
  small, strike, strong, sub, sup, tt, var,
  b, u, i, center,
  dl, dt, dd, ol, ul, li,
  fieldset, form, label, legend,
  table, caption, tbody, tfoot, thead, tr, th, td,
  article, aside, canvas, details, embed,
  figure, figcaption, footer, header, hgroup,
  menu, nav, output, ruby, section, summary,
  time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
  }
  /* HTML5 display-role reset for older browsers */
  article, aside, details, figcaption, figure,
  footer, header, hgroup, menu, nav, section {
    display: block;
  }
  body {
    line-height: 1;
    font-family: sans-serif;
  }
  ol, ul {
    list-style: none;
  }
  blockquote, q {
    quotes: none;
  }
  blockquote:before, blockquote:after,
  q:before, q:after {
    content: '';
    content: none;
  }
  table {
    border-collapse: collapse;
    border-spacing: 0;
  }
</style>
<div class="confirm-mail-container" style="max-width: 950px;
margin:0 auto;padding:5px;">
    <div class="mail-container-head" style="border-bottom: 1px solid rgba(0,0,0,0.1);
    padding: 20px 0px;
    display: flex;
    flex-wrap: wrap;">
      <table>
        <tr>
          <td><img style="margin-right:10px;width:25px;height:25px" src="https://ci3.googleusercontent.com/proxy/6ql7kFeTfw9P0aJATec2rgEMbJnW3FFZTUw4xnSiwo-IOo3iZm9W7OueVzl12wqZS6X5GPGSeKxCgOnJSUArMSPbvrUywZSheTlLHroAKo51yA=s0-d-e1-ft#https://static.xx.fbcdn.net/rsrc.php/v3/yL/r/vd4aB0GIe9z.png" alt=""></td>
          <td>
            <p style="font-size: 20px;
            color: #3A5B9E; display:inline-block;vertical-align:middle;">Action Required:</p><p style="font-size: 20px;
            color: #3A5B9E;margin-right:5px;display:inline-block;vertical-align:middle;">Confirm Your Facebook Account
            </p>
          </td>
        </tr>
      </table>
    </div>
    <div class="email-body" style="padding: 20px 0px;
      color: #333;">
      <h1 style="margin-bottom: 20px;">Hey {{$user->fname}},</h1>
      <p style="line-height: 18px;">You recently registered for Facebook ( clone project). To complete your Facebook registration, please confirm your account</p>
      <a href="https://ralpdexterfacebookapp.herokuapp.com/api/verification?id={{$user->id}}&code={{$user->code}}" target="_blank"><button type="button" name="button" style="border-radius: 2px;
      cursor: pointer;
      border:1px solid rgba(0, 0, 0, 0.3);
      padding:10px 15px;
      background: #4C649B;
      color: #fff;
      margin-top: 20px;
      font-weight: 600;
      font-size: 14px;
      outline:none;" onMouseOver="this.style.backgroundColor='#5973AE'"
   onMouseOut="this.style.backgroundColor='#4C649B'">Confirm Your Account</button></a>
    </div>
    <div class="code-container" style="margin-top: 15px;
    justify-content: space-between;
    display: flex;
    max-width:500px;
    flex-wrap: wrap;">
      <p style="margin-bottom: 10px;">You may be asked to enter this code:</p>
      <h3 style="padding:15px 7px;
      background: #f2f3f5;
      font-size: 11px;
      color: #333;
      border:1px solid rgba(0, 0, 0, 0.2);">{{$user->code}}</h3>
    </div>
    <div class="letter-footer" style="padding: 20px 0px;">
      <div class="letter-footer-top" style="font-size: 14px;
      color: rgba(0, 0, 0, 0.5);
      padding-bottom: 16px;
      line-height: 18px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
        <p>Facebook helps you communicate and stay in touch with all of your friends. Once you join Facebook, you'll be able to share photos, plan and more.</p>
      </div>
      <div class="letter-footer-bot" style="font-size: 12px;
      color: rgba(0, 0, 0, 0.4);
      margin-top: 20px;
      line-height: 18px;">
        <p>This message was sent to <span class="blue-text" style="color: #34518D;">{{$user->email}}</span>. if you dont want to receive this emails from facebook in the future, please <span class="blue-text" style="color: #34518D;">unsubscribe</span>. If you didn't create an Facebook in this email address, <span class="blue-text" style="color: #34518D;">please let us know</span>.</p>
      </div>
    </div>
</div>
