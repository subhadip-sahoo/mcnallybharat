<?php
/* Template Name: Submit Resume Form */
get_header();
?>
<div class="main_contaner">
    <h2><?php the_title();?></h2>
    <form>
    <p>Personal Date</p>
    <dl>
      <dt>Full Name *</dt>
      <dd><input type="text"></dd>
      <dt>Date of Birth *</dt>
      <dd><select></select></dd>
      <dt>Sex *</dt>
      <dd><input type="radio" value="Male" class="check" name="txtsex"></dd>
      <dt>Contact Phone</dt>
      <dd>
            <dl>
                    <dt>STD Code*</dt>
                    <dd><input type="text"></dd>
                    <dt>Phone/ Mobile No.*</dt>
                    <dd><input type="text"></dd>
            </dl>
      </dd>
      <dt>Email Address *</dt>
      <dd><input type="text"></dd>
      <dt>Contact Address *</dt>
      <dd><input type="text"></dd>
      <dt>Pin Code*</dt>
      <dd><input type="text"></dd>
      <dt>Are you applying against Advertisement *</dt>
      <dd><input type="radio"></dd>
    </dl>
    <p>Qualification</p>
    <table>
            <tr>
                    <td>Examination</td>
                    <td>Branch<br>(Civil/ Mech/ Elec. etc.)</td>
                    <td>Year of Passing</td>
                    <td>F/ P/ C</td>
                    <td>Qualification Type</td>
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><select></select></td>
                    <td><select></select></td>
                    <td><select></select></td>
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><select></select></td>
                    <td><select></select></td>
                    <td><select></select></td>
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><select></select></td>
                    <td><select></select></td>
                    <td><select></select></td>
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><select></select></td>
                    <td><select></select></td>
                    <td><select></select></td>
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>
                    <td><select></select></td>
                    <td><select></select></td>
                    <td><select></select></td>
            </tr>
    </table>
    <p>Experience</p>
    <table>
            <tr>
                    <th>Employer's Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Designation & Nature of Work Done</th>		
            </tr>
            <tr>
                    <td><input type="text" maxlength="30" size="15" name="txtexam1"></td>		
                    <td><select></select> <select></select></td>
                    <td><select></select> <select></select></td>
                    <td><textarea></textarea></td>
            </tr>
    </table>
    <p>Other Information</p>
    <dl>
      <dt>Are you willing to be posted anywhere in India? *</dt>
      <dd><input type="radio"></dd>
      <dt>Have you ever been employed by us or by any of our Subsidiary/ Associate Companies? *</dt>
      <dd><input type="radio"></dd>
      <dt>Have you ever been interviewed by us? *</dt>
      <dd><input type="radio"></dd>
      <dt>Have you any relatives employed by us or by any of our Subsidiary / Associate Companies? *</dt>
      <dd><input type="radio"></dd>
      <dt>Expected Salary *</dt>
      <dd><input type="text"></dd>
      <dt>Enter Image Verification Code *</dt>
      <dd>captcha</dd>
      <dt></dt>
      <dd><input type="text"></dd>
      <dt>Are you applying against Advertisement *</dt>
      <dd><input type="radio"></dd>
      <dt><input type="submit"></dt>
      <dd><input type="reset"></dd>
    </dl>
    </form>
    <div class="clr"></div>
</div>
<?php get_footer();?>