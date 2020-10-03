<?php
    // 判断post是否传过来sub参数,从而判断是提交计算,还是刷新页面
    if (isset($_POST['sub'])){
        echo "用户点击提交按钮，提交计算请求<br>";

        // 判断两个运算元是否为数字
        if (!is_numeric($_POST['num1']) || !is_numeric($_POST['num2'])){
            $isDo = false;
            echo "存在运算元不是数字，无法运算<br>";
        }
        else{
            $isDo = true;
        }
 
        // 声明变量 计算结果
        $sum = "";
 
        if ($isDo){ // 判断两个运算元是否为数字
            switch ($_POST['ysf']){
                case '+':
                    $sum = $_POST['num1'] + $_POST['num2'];
                    break;
                case '-':
                    $sum = $_POST['num1'] - $_POST['num2'];
                    break;
                case '*':
                    $sum = $_POST['num1'] * $_POST['num2'];
                    break;
                case '/':
                    $sum = $_POST['num1'] / $_POST['num2'];
                    break;
                case '%':
                    $sum = $_POST['num1'] % $_POST['num2'];
                    break;
            }
            echo "$sum<br>";
        }
    }
    else{
        echo "请刷新页面<br>";
    }
?>
 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--声明字符编码-->
    <title>简易计算器</title>
</head>
<body background="樱花季.jpg">
<table border="1" width="400" align="center" background="紫色.jpg">
    <form action="" method="post">
    <!--action发送数据到新的表单，method以何种方式发送-->
        <caption><h1><font color="White">CleanCalculator</font></h1></caption>
        <caption><h1><font style="font-family:隶书" color="White">简易计算器</font><br /></h1></caption>
        <caption><h4><font color="White">Daphne_Liu</font></h4></caption>
        <!--caption 定义表格标题-->
        <tr>
            <!--第一个运算元-->
            <td><input type="text" size="5" name="num1" value="<?php
                if (isset($_POST['sub'])){echo $_POST['num1'];} ?>"></td>
            
            <!--运算符-->
            <td>
                <select name="ysf">
                    <option <?php 
                        if (isset($_POST['sub'])){if ($_POST['ysf']=="+") echo "selected";} 
                            ?> value="+"> + </option>    
                    <option <?php 
                        if (isset($_POST['sub'])){if ($_POST['ysf']=="-") echo "selected";}
                            ?> value="-"> - </option>     
                    <option <?php 
                        if (isset($_POST['sub'])){if ($_POST['ysf']=="*") echo "selected";} 
                            ?> value="*"> * </option> 
                    <option <?php 
                        if (isset($_POST['sub'])){if ($_POST['ysf']=="/") echo "selected";}
                            ?> value="/"> / </option>
                    <option <?php 
                        if (isset($_POST['sub'])){if ($_POST['ysf']=="%") echo "selected";} 
                            ?> value="%"> % </option>  
                </select>
            </td>
            
            <!--第二个运算元-->
            <td><input type="text" size="5" name="num2" value="<?php
                if (isset($_POST['sub'])){echo $_POST['num2'];} ?>"></td>
            
            <!--提交-->
            <td><input type="submit" name="sub" value="等于"></td>
        </tr>
        <tr>
            <td colspan="4">
            <!--跨四列-->
                <?php
                    if (isset($_POST['sub'])){
                        echo "计算结果：{$_POST['num1']}{$_POST['ysf']}{$_POST['num2']} = {$sum}";
                    }
                ?>
            </td>
        </tr>
    </form>
</table>
</body>
</html>



<?php
$link=mysqli_connect("localhost:3306","root","147258","calculatordb","3306");
//连接数据库
if($link){
    echo "连接数据库成功";
}
else{
    echo "连接数据库失败";
}

mysqli_select_db($link,"calculatordb");
//选择数据库

mysqli_query($link,"set names 'utf8'");
//防止乱码

$sql1="INSERT INTO formula VALUES ($_POST[num1],'$_POST[ysf]',$_POST[num2],$sum)";
//向表中添加信息（2 + 1 3）
echo"<br>";
$result=mysqli_query($link,$sql1);
//sql语句传送到数据库运行
if($result==false){
    echo"执行失败";
}
else{
    echo"执行成功";
}

$sql2="select num1,ysf,num2,sum from formula";
//读取数据库中的数据
$query= mysqli_query($link,$sql2);

//以表格形式显示数据
echo"<table border='1'align='center'background='紫色.jpg'>
<tr>
    <th>第一个运算元</th>
    <th>运算符</th>
    <th>第二个运算元</th>
    <th>结果</th>
</tr>";
while($row=mysqli_fetch_array($query)){
    echo "<tr>";
    echo "<td>" . $row['num1'] . "</td>";
    echo "<td>" . $row['ysf'] . "</td>";
    echo "<td>" . $row['num2'] . "</td>";
    echo "<td>" . $row['sum'] . "</td>";
    echo "</tr>";
} 

echo"</table>";
mysqli_close($link);
//关闭数据库
?>