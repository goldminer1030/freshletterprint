{*
*  @author goldminer1030
*}
{if $visible > 0}
  <div class="fresh-letter-print">
    <div class="fresh-letter-group">
      <label>Your Letter Text</label>
      <input type="text" class="fresh-letter-input" placeholder="Enter Lettering">
    </div>

    <div class="fresh-letter-group">
      <label>Your Letter Font</label>
      <select name="fresh-letter-font" class="fresh-letter-font">
        <option selected="selected">1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
        <option>6</option>
        <option>7</option>
        <option>8</option>
        <option>9</option>
        <option>10</option>
      </select>
    </div>

    <div class="fresh-letter-group">
      <label>Your Letter Size</label>
      <div id="fresh-letter-size-slider"></div>
    </div>

    <div class="fresh-letter-group">
      <label>Your Letter Material</label>
      <span class="color texture"></span>
      <span class="color texture"></span>
      <span class="color texture"></span>
    </div>

    <div class="fresh-letter-group">
      <label>Your Letter Color</label>
      <span class="color"></span>
      <span class="color"></span>
      <span class="color"></span>
      <span class="color"></span>
      <span class="color"></span>
    </div>

    <div class="fresh-letter-group">
      <label>Your Letter Preview</label>
    </div>
  </div>
{/if}
