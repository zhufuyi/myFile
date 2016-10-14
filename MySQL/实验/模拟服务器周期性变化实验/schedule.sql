# (1)创建新的库
CREATE DATABASE schedule;

# (2)进入schedule数据库
USE schedule;

# (3)在schedule数据库下创建表
CREATE TABLE plan_task (
    id               INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, # 主键
    creat_at         TIMESTAMP                               NOT NULL DEFAULT CURRENT_TIMESTAMP, # 创建时间
    task_no          INT UNSIGNED                            NOT NULL DEFAULT 0, # 任务编号
    execute_type     TINYINT                                 NOT NULL DEFAULT 0, # 执行任务类型
    execute_status   TINYINT                                 NOT NULL DEFAULT 0, # 当前执行状态
    background_color MEDIUMINT UNSIGNED                      NOT NULL DEFAULT 0, # 背景颜色
    font_color       MEDIUMINT UNSIGNED                      NOT NULL DEFAULT 0, # 字体颜色
    start_time       INT UNSIGNED                            NOT NULL DEFAULT 0, # 任务开始时间
    end_time         INT UNSIGNED                            NOT NULL DEFAULT 0  # 任务结束时间
)ENGINE myisam DEFAULT CHARSET utf8;


# (4)模拟数据生成器函数（在规定范围随机生成），用来填充表数据
#    注意，这个函数不能在终端执行，因为分号冲突，需要使用phpstorm或phpMyadmin执行
CREATE PROCEDURE generate_data(cnt INT)
    BEGIN
        DECLARE st INT UNSIGNED DEFAULT 0;
        DECLARE et INT UNSIGNED DEFAULT 0;
        WHILE cnt > 0 DO
            SET cnt := cnt - 1;
            SET st := floor(rand() * 31622401) + 1451577600;
            SET et := st + floor(rand() * 1740) + 60;

            INSERT INTO plan_task (task_no, execute_type, execute_status, background_color, font_color, start_time, end_time)
            VALUES (floor(rand() * 100), floor(rand() * 2), floor(rand() * 5), floor(rand() * 16777216),
                    floor(rand() * 16777216), st, et);
        END WHILE;
    END;


# (5)添加150000000行数据，随机生成
CALL generate_data(5000000); 
CALL generate_data(5000000);
CALL generate_data(5000000);   






